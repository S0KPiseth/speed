<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\UserController;

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/home');
Route::view('/signup', 'pages.signup', ['linkName' => 'signup', 'user' => null]);
Route::get('/login', function () {
    if (!Auth::check()) {

        return view('pages.login')->with(['linkName' => 'login', 'user' => null]);
    } else {
        return to_route('index', ['nav']);
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
Route::get('/{nav}', function ($nav) {
    $user = Auth::user();
    return view('layout.tab')->with('linkName', $nav)->with('user', $user);
});
