<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function settings(Request $request) {
        $user = Auth::user();
        $profiles = DB::table('users')->orderBy('name', 'asc')->get();
        $userInfo = DB::table('users')->where('id', $user->id)->first();
        $userName = $userInfo->name;
        $currName = $userInfo->currname;
        $settings = DB::table('settings')->first();//Загружаем настройки
        $currentTimezone = $settings->timezone;
        $timezones = DB::table('timezones')->get();

        return view('settings', ['timezones' => $timezones, 'currentTimezone' => $currentTimezone, 'settings' => $settings, 'userInfo' => $userInfo, 'userName' => $userName, 'currName' => $currName, 'profiles' => $profiles]);
    }
    public function getSettings(Request $request) {
        if ($request->isMethod('post'))
        {
            $user = Auth::user();
            $userInfo = DB::table('users')->where('id', $user->id)->first();
            $userName = $userInfo->name;
            $currName = $userInfo->currname;
            $settings = DB::table('settings')->first();//Загружаем настройки
            $currentTimezone = $settings->timezone;
            $timezones = DB::table('timezones')->get();
            $newTimezone = $request->timezone;
            if($userInfo->name != 'admin') {
                $this->validate($request, [
                    'userName' => 'max:100',
                ]);
            }
            else {
                $this->validate($request, [
                    'title' => 'required|max:75',
                    'userName' => 'max:100',
                ]);
                $favicon = $request->favicon;
                $updateFavicon =  DB::table('settings')
                    ->where('id', '=', 1)
                    ->update(['favicon' => $favicon,
                    ]);
                $search = $request->poisk;
                $updateSearch =  DB::table('settings')
                    ->where('id', '=', 1)
                    ->update(['search' => $search,
                    ]);
                $version = $request->countVersion;
                $updateVersion =  DB::table('settings')
                    ->where('id', '=', 1)
                    ->update(['version' => $version,
                        'timezone' => $newTimezone,
                    ]);
                $metrika = $request->metrika;
                $updateMetrika =  DB::table('settings')
                    ->where('id', '=', 1)
                    ->update(['metrika' => $metrika,
                        'timezone' => $newTimezone,
                    ]);
                $updateTitle =  DB::table('settings')
                    ->where('id', '=', 1)
                    ->update(['title' => $request->title,
                    ]);
                $updateTimezone =  DB::table('settings')
                    ->where('id', '=', 1)
                    ->update(['oldtimezone' => $settings->timezone,
                        'timezone' => $newTimezone,
                    ]);
                $currentTimezone = $newTimezone;
            }
            $currName = $request->currName;
            if($currName == 1) {
                $updateFullName =  DB::table('users')
                    ->where('id', '=', $user->id)
                    ->update(['currname' => 1,
                    ]);
            }
            else {
                $updateFullName =  DB::table('users')
                    ->where('id', '=', $user->id)
                    ->update(['currname' => 0,
                    ]);
            }
            $updateFullName =  DB::table('users')
                ->where('id', '=', $user->id)
                ->update(['fullname' => $request->userName,
                ]);
            $userName = $request->userName;
            return redirect('/settings');

        }
    }
}
