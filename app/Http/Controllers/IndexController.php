<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class IndexController extends Controller
{
    /**
     * Нормализует внутренний URL страницы для сравнения ссылок.
     */
    private function normalizePageUrl($url)
    {
        $path = parse_url(trim((string) $url), PHP_URL_PATH);

        if (!$path) {
            return null;
        }

        $path = '/' . ltrim($path, '/');
        $path = rtrim($path, '/');

        return $path === '' ? '/' : $path;
    }

    /**
     * Проверяет, есть ли на запрашиваемую страницу прямая ссылка в текстах статей.
     * Учитываются относительные и абсолютные ссылки вида /index/page и https://site.ru/index/page.
     */
    private function hasDirectTextLinkToPage($targetUrl)
    {
        $targetUrl = $this->normalizePageUrl($targetUrl);

        if (!$targetUrl || $targetUrl === '/index') {
            return true;
        }

        $pages = DB::table('page')
            ->where('h1', '!=', 'Страница удалена')
            ->whereNotNull('text')
            ->pluck('text');

        foreach ($pages as $text) {
            if (!is_string($text) || $text === '') {
                continue;
            }

            preg_match_all('/<a\s+[^>]*href=["\']([^"\']+)["\']/iu', $text, $matches);

            foreach ($matches[1] ?? [] as $href) {
                if ($this->normalizePageUrl(html_entity_decode($href, ENT_QUOTES, 'UTF-8')) === $targetUrl) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Чистит HTML из редактора от битых ссылок, из-за которых CKEditor может
     * воспринимать всю статью как одну ссылку и падать при удалении link.
     */
    private function stripAnchorTags($html)
    {
        $html = preg_replace('/<a\b[^>]*>/iu', '', (string) $html);
        return preg_replace('/<\/a>/iu', '', (string) $html);
    }

    private function sanitizeEditorHtmlWithoutDom($html)
    {
        $html = (string) $html;

        if ($html === '') {
            return $html;
        }

        $openLinks = preg_match_all('/<a\b[^>]*>/iu', $html);
        $closeLinks = preg_match_all('/<\/a>/iu', $html);

        // Главная причина текущего бага: в статье есть незакрытый <a>,
        // из-за чего браузер растягивает ссылку на форму редактирования.
        if ($openLinks !== $closeLinks) {
            return $this->stripAnchorTags($html);
        }

        $plainTextLength = mb_strlen(trim(strip_tags($html)), 'UTF-8');
        $linkedTextLength = 0;

        preg_match_all('/<a\b[^>]*>(.*?)<\/a>/isu', $html, $matches);
        foreach ($matches[1] ?? [] as $linkedHtml) {
            $linkedTextLength += mb_strlen(trim(strip_tags($linkedHtml)), 'UTF-8');
        }

        if ($plainTextLength > 120 && $linkedTextLength / max($plainTextLength, 1) > 0.75) {
            return $this->stripAnchorTags($html);
        }

        $blockTagsPattern = '<\s*(p|div|ul|ol|li|h1|h2|h3|h4|h5|h6|blockquote|table|figure|img|iframe)\b';

        return preg_replace_callback('/<a\b([^>]*)>(.*?)<\/a>/isu', function ($match) use ($blockTagsPattern) {
            $attributes = $match[1] ?? '';
            $content = $match[2] ?? '';

            $isUnsafe = preg_match('/href\s*=\s*["\']?\s*javascript\s*:/iu', $attributes);
            $hasEmptyHref = preg_match('/href\s*=\s*(["\'])\s*\1/iu', $attributes);
            $hasBlockContent = preg_match('/' . $blockTagsPattern . '/iu', $content);

            if ($isUnsafe || $hasEmptyHref || $hasBlockContent) {
                return $content;
            }

            return $match[0];
        }, $html);
    }

    /**
     * Чистит HTML из редактора от битых ссылок, из-за которых CKEditor может
     * воспринимать всю статью как одну ссылку, а браузер — растягивать <a>
     * на поля и кнопки админки.
     */
    private function sanitizeEditorHtml($html)
    {
        $html = (string) $html;

        if ($html === '') {
            return $html;
        }

        // Быстрая обязательная проверка работает даже без PHP DOM extension.
        $html = $this->sanitizeEditorHtmlWithoutDom($html);

        if (!class_exists('DOMDocument')) {
            return $html;
        }

        $previous = libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML('<?xml encoding="UTF-8"><div id="editor-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new \DOMXPath($dom);
        $root = $dom->getElementById('editor-root');

        if (!$root) {
            return $html;
        }

        $totalTextLength = mb_strlen(trim($root->textContent ?? ''), 'UTF-8');
        $linkedTextLength = 0;
        $links = [];

        foreach ($xpath->query('.//a', $root) as $link) {
            $links[] = $link;
            $linkedTextLength += mb_strlen(trim($link->textContent ?? ''), 'UTF-8');
        }

        $looksLikeWholeArticleLink = $totalTextLength > 120 && $linkedTextLength / max($totalTextLength, 1) > 0.75;
        $blockTags = ['p','div','ul','ol','li','h1','h2','h3','h4','h5','h6','blockquote','table','figure','img','iframe'];

        foreach ($links as $link) {
            $href = trim($link->getAttribute('href'));
            $unsafeHref = stripos($href, 'javascript:') === 0;
            $hasBlockContent = false;

            foreach ($blockTags as $tag) {
                if ($link->getElementsByTagName($tag)->length > 0) {
                    $hasBlockContent = true;
                    break;
                }
            }

            if ($looksLikeWholeArticleLink || $hasBlockContent || $unsafeHref || $href === '') {
                while ($link->firstChild) {
                    $link->parentNode->insertBefore($link->firstChild, $link);
                }
                $link->parentNode->removeChild($link);
            }
        }

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $dom->saveHTML($child);
        }

        return $clean;
    }

    /**
     * Готовит HTML статьи к безопасному выводу в шаблоне и открытию в CKEditor.
     * Это важно для старых материалов с незакрытым <a>, когда ссылка визуально
     * захватывает форму редактирования, кнопки и поля админки.
     */
    private function preparePageTextForView($indexText)
    {
        if ($indexText && isset($indexText->text)) {
            $indexText->text = $this->sanitizeEditorHtml(
                html_entity_decode((string) $indexText->text, ENT_QUOTES | ENT_HTML5, 'UTF-8')
            );
        }

        return $indexText;
    }

    public function index() {
        $userInfo = DB::table('users')->where('name', 'admin')->first();
        $currName = 1;
        if(Auth::user()) {
        $user = Auth::user();
        $currName = $user->currname;
            }
        $settings = DB::table('settings')->first();//загружаем настройки
        $indexText = DB::table('page')->where('url' , '=', '/index')->first();
        $indexText = $this->preparePageTextForView($indexText);
        $i = 0;
        $updateViews =  DB::table('page')
            ->where('url', '=', '/index')
            ->increment('views');
        $countModerate = DB::table('moderate')->count();
        return view('dashboard', ['indexText' => $indexText, 'settings' => $settings, 'userInfo' => $userInfo, 'currName' => $currName, 'countModerate' => $countModerate]);
    }
    public function newPage(Request $request) {
        $url = $this->normalizePageUrl('/index/' . $request->id);

        if (!$this->hasDirectTextLinkToPage($url)) {
            abort(404);
        }

        $newUrlData = DB::table('page')->where('url', '=', $url)->get();
        if(count($newUrlData) == 0) {
            DB::table('page')->insert([
                ['url' => $url, 'h1' => __('ui.new_article_h1'), 'text' => __('ui.new_article_text'), 'views' => 1, 'img' => '/img/logo-wiki.webp', 'date' => date('Y-m-d H:i:s')],
            ]);
        }
            $userInfo = DB::table('users')->where('name', 'admin')->first();
            $currName = 1;
            if (Auth::user()) {
                $user = Auth::user();
                $currName = $user->currname;
            }
            $settings = DB::table('settings')->first();//загружаем настройки
            $indexText = DB::table('page')->where('url', '=', $url)->first();

            if (!$indexText || $indexText->h1 === 'Страница удалена') {
                abort(404);
            }

            $indexText = $this->preparePageTextForView($indexText);

            $i = 0;
            $updateViews = DB::table('page')
                ->where('url', '=', $url)
                ->increment('views');
        $countModerate = DB::table('moderate')->count();

        return view('page', ['indexText' => $indexText, 'settings' => $settings, 'userInfo' => $userInfo, 'currName' => $currName, 'countModerate' => $countModerate]);
    }
    public function saveMain(Request $request) {
        if ($request->isMethod('post'))
        {
            $newh1 = $request->newh1;
            $newText = $request->input('newTextHtml', $request->newText);
            $newText = html_entity_decode($newText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $newText = $this->sanitizeEditorHtml($newText);
            $url = $request->url;
            date_default_timezone_set('Europe/Moscow');
            $user = Auth::user();
            if($user->name == 'admin') {
                $updateTextH1 = DB::table('page')
                    ->where('url', '=', $url)
                    ->update(['h1' => $newh1,
                        'text' => $newText,
                        'date' => date('Y-m-d H:i:s'),
                    ]);
                return back()
                    ->with('success', __('ui.updated_successfully'));
            }
            elseif($user->name != 'admin') {
                DB::table('moderate')->insert([
                    ['url' => $request->url, 'h1' => $newh1, 'text' => $newText, 'date' => date('Y-m-d H:i:s'), 'user' => $user->name],
                ]);
                return back()
                    ->with('success', __('ui.sent_to_moderation'));
            }
        }

    }
    public function saveMainImage (Request $request) {
        if ($request->isMethod('post')) {
            // Валидация
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);
            $url = $request->url2;
            // Имя файла
            $imageName = time() . '.' . $request->image->extension();
            // Перемещение файла в public/uploads
            $request->image->move(public_path('uploads'), $imageName);
            $updateImg =  DB::table('page')
                ->where('url', '=', $url)
                ->update(['img' => '/uploads/'.$imageName,
                ]);
            // Возврат или сообщение об успехе
            return back()
                ->with('success', __('ui.image_uploaded'))
                ->with('image', 'uploads/' . $imageName);

        }
        }

        public function uploadEditorImage(Request $request) {
            if (!Auth::check() || Auth::user()->name !== 'admin') {
                return response()->json([
                    'error' => ['message' => __('ui.upload_no_rights')]
                ], 403);
            }

            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            $file = $request->file('upload');
            $imageName = 'editor_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);

            return response()->json([
                'url' => '/uploads/' . $imageName,
            ]);
        }
        public function deletePage(Request $request) {
            $url = $request->url3;
            $updateImg =  DB::table('page')
                ->where('url', '=', $url)
                ->update(['h1' => 'Страница удалена', 'text' => __('ui.deleted_page_text'), 'img' => '/img/logo-wiki.webp',
                ]);
            return redirect('/index')
                ->with('success', __('ui.page_deleted'));

        }
        public function random(Request $request) {
            $random = DB::table('page')->inRandomOrder()->where('h1' ,'!=', 'Страница удалена')->first();
            return redirect($random->url);
        }
        public function new() {
            $new = DB::table('page')->where('h1' ,'!=', 'Страница удалена')->OrderBy('date', 'desc')->first();
            return redirect($new->url);
        }
        public function moderate(Request $request) {
            $settings = DB::table('settings')->first();//загружаем настройки
            $currName = 1;
            if (Auth::user()) {
                $user = Auth::user();
                $currName = $user->currname;
            }
            if ($request->isMethod('post')) {
                if($request->type =='delete'){
                    DB::delete("delete from moderate where text = '{$request->text}' AND h1 = '{$request->h1}'");
                    return redirect('/moderate')
                        ->with('success', __('ui.page_deleted'));
                }
                else{
                    $article = DB::table('moderate')->where(['text' ,'=', $request->text], ['h1' ,'=', $request->h1])->first();
                    $updateArticle =  DB::table('page')
                        ->where('text', '=', $request->text)
                        ->update(['h1' => $article->h1, 'text' => $article->text, 'date' => $article->date,
                        ]);
                    DB::delete("delete from moderate where text = '{$request->text}' AND h1 = '{$request->h1}'");
                    return redirect('/moderate')
                        ->with('success', __('ui.page_updated'));
                }


            }

        $articlesModerate = DB::table('moderate')->orderBy('date', 'desc')->limit($settings->version)->get();
        return view('moderate', ['articles' => $articlesModerate, 'settings' => $settings, 'currName' => $currName]);
        }
}
