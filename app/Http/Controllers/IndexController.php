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

    public function index() {
        $userInfo = DB::table('users')->where('name', 'admin')->first();
        $currName = 1;
        if(Auth::user()) {
        $user = Auth::user();
        $currName = $user->currname;
            }
        $settings = DB::table('settings')->first();//загружаем настройки
        $indexText = DB::table('page')->where('url' , '=', '/index')->first();
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
                ['url' => $url, 'h1' => 'Наша новая статья', 'text' => '<p>Здесь должен быть лаконичный текст :)</p>', 'views' => 1, 'img' => '/img/logo-wiki.webp', 'date' => date('Y-m-d H:i:s')],
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
            $newText = $request->newText;
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
                    ->with('success', 'Текст успешно отредактирован!');
            }
            elseif($user->name != 'admin') {
                DB::table('moderate')->insert([
                    ['url' => $request->url, 'h1' => $newh1, 'text' => $newText, 'date' => date('Y-m-d H:i:s'), 'user' => $user->name],
                ]);
                return back()
                    ->with('success', 'Текст отправлен на модерацию!');
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
                ->with('success', 'Изображение успешно загружено!')
                ->with('image', 'uploads/' . $imageName);

        }
        }

        public function uploadEditorImage(Request $request) {
            if (!Auth::check() || Auth::user()->name !== 'admin') {
                return response()->json([
                    'error' => ['message' => 'Недостаточно прав для загрузки изображения.']
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
                ->update(['h1' => 'Страница удалена', 'text' => '<p>Страница больше не используется.</p>', 'img' => '/img/logo-wiki.webp',
                ]);
            return redirect('/index')
                ->with('success', 'Страница успешно удалена!');

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
                        ->with('success', 'Страница успешно удалена!');
                }
                else{
                    $article = DB::table('moderate')->where(['text' ,'=', $request->text], ['h1' ,'=', $request->h1])->first();
                    $updateArticle =  DB::table('page')
                        ->where('text', '=', $request->text)
                        ->update(['h1' => $article->h1, 'text' => $article->text, 'date' => $article->date,
                        ]);
                    DB::delete("delete from moderate where text = '{$request->text}' AND h1 = '{$request->h1}'");
                    return redirect('/moderate')
                        ->with('success', 'Страница успешно обновлена!');
                }


            }

        $articlesModerate = DB::table('moderate')->orderBy('date', 'desc')->limit($settings->version)->get();
        return view('moderate', ['articles' => $articlesModerate, 'settings' => $settings, 'currName' => $currName]);
        }
}
