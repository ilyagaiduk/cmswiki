<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SettingsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::match(['get', 'post'],'/index', [IndexController::class, 'index'])->name('dashboard');
Route::match(['get', 'post'],'/index/{id}', [IndexController::class, 'newPage'])->name('newPage');
Route::match(['get', 'post'],'/deletepage', [IndexController::class, 'deletePage'])->name('deletePage');
Route::match(['get', 'post'],'/random', [IndexController::class, 'random'])->name('random');
Route::match(['get', 'post'],'/new', [IndexController::class, 'new'])->name('new');
Route::match(['get', 'post'],'/moderate', [IndexController::class, 'moderate'])->name('moderate');
Route::match(['get', 'post'],'/settings', [SettingsController::class, 'settings'])->middleware(['auth'])->name('settings');
Route::match(['get', 'post'],'/getsettings', [SettingsController::class, 'getSettings'])->middleware(['auth'])->name('getSettings');
Route::match(['get', 'post'],'/savemain', [IndexController::class, 'saveMain'])->middleware(['auth'])->name('saveMain');
Route::match(['get', 'post'],'/savemainimage', [IndexController::class, 'saveMainImage'])->middleware(['auth'])->name('saveMainImage');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
