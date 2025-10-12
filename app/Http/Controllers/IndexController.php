<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class IndexController extends Controller
{
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
        $newUrlData = DB::table('page')->where('url' , '=', '/index/'.$request->id)->get();
        if(count($newUrlData) == 0) {
            DB::table('page')->insert([
                ['url' => '/index/'.$request->id, 'h1' => 'Наша новая статья', 'text' => '<p>Здесь должен быть лаконичный текст :)</p>', 'views' => 1, 'img' => '/img/logo-wiki.webp', 'date' => date('Y-m-d H:i:s')],
            ]);
        }
            $userInfo = DB::table('users')->where('name', 'admin')->first();
            $currName = 1;
            if (Auth::user()) {
                $user = Auth::user();
                $currName = $user->currname;
            }
            $settings = DB::table('settings')->first();//загружаем настройки
            $indexText = DB::table('page')->where('url', '=', '/index/' . $request->id)->first();
            $i = 0;
            $updateViews = DB::table('page')
                ->where('url', '=', '/index/' . $request->id)
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
