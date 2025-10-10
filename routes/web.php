<?php

use App\Http\Controllers\addController;
use App\Http\Controllers\buyController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\sellController;

use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/home');
Route::view('/signup', 'pages.signup', ['linkName' => 'signup', 'user' => null]);
Route::get('/login', function () {
    if (!Auth::check()) {

        return view('pages.login')->with(['linkName' => 'login', 'user' => null]);
    } else {
        return to_route('index');
    }
})->name('login');


Route::post('/login', loginController::class);

Route::controller(UserController::class)->group(function () {
    Route::post('/signup', 'store');
});
Route::get('/logout', function () {
    if (!Auth::check()) {
        return redirect('/home');
    } else {
        Auth::logout();
        return redirect('/home');
    }
});
Route::prefix('buy')->controller(buyController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/details/{id}', 'showDetails')->name('details');
});
Route::prefix('add')->name('add.')->controller(addController::class)->group(
    function () {
        Route::post('/cart', 'cart')->name('cart');
        Route::post('/wishlist', 'wishlist')->name('wishlist');
    }
)->middleware('auth');
Route::controller(sellController::class)->prefix('sell')->name('sell.')->middleware('auth')->group(function () {
    Route::get('/', 'index');
    Route::get('/car_info', 'inputInfo')->name('input');
    Route::post('/car_info', 'submitInfo')->name('submit');
});
Route::get('/home', function () {
    return view('pages.home');
})->name('index');
