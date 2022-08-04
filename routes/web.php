<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\WebAuthController::class, 'index']);
Route::group(['middleware' => ['web']], function () {
    Route::resource('events', \App\Http\Controllers\EventController::class);
    Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts');
    Route::get('logout', [\App\Http\Controllers\WebAuthController::class, 'logout'])->name('logout');
});
Route::get('login', [\App\Http\Controllers\WebAuthController::class, 'index'])->name('login');
Route::post('doLogin', [\App\Http\Controllers\WebAuthController::class, 'doLogin'])->name('doLogin');
Route::post('doRegister', [\App\Http\Controllers\WebAuthController::class, 'doRegister'])->name('doRegister');
Route::get('register', [\App\Http\Controllers\WebAuthController::class, 'register'])->name('register');
