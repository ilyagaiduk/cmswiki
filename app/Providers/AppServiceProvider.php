<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $locale = 'ru';

        try {
            if (Schema::hasTable('settings') && Schema::hasColumn('settings', 'language')) {
                $settings = DB::table('settings')->first();
                $savedLocale = $settings->language ?? null;

                if (in_array($savedLocale, ['ru', 'en'], true)) {
                    $locale = $savedLocale;
                }
            }
        } catch (\Throwable $exception) {
            $locale = 'ru';
        }

        App::setLocale($locale);
        View::share('interfaceLanguage', $locale);
    }
}
