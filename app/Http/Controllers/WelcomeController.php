<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $startUrl = DB::table('start_url')->where('url', '=', 'index')->first();
        if($startUrl->get == 1) {
            return redirect('/index');
        }
        else {
            return view('welcome');
        }
    }
}
