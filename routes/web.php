<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PublishController;
use App\Http\Controllers\ConnectController;
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

Route::middleware('auth')->group( function() { 
    Route::get('/', function () {
        return view('pages.account');
    });
    Route::get('/logout', function(){   
        Auth::logout();
        return redirect('/login');
                
    })->name('logout');

    // publish 

    route::get('/publish', [PublishController::class, 'index'])->name('publish');
    route::post('/publish', [PublishController::class, 'store']);
    route::post('/publish/scheduled', [PublishController::class, 'storeScheduled'])->name('scheduled');

    // connect 

    route::get('/connect', [ConnectController::class, 'index'])->name('connect');
});
Route::middleware('guest')->group( function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


// /facebook/callback
 
Route::get('/facebook/redirect', [LoginController::class, 'FacebookRedirect'])->name('facebook.redirect');
 
Route::get('/facebook/callback', [LoginController::class, 'FacebookCallback'])->name('facebook.callback');