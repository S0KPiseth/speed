<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/home');
Route::view('/signup', 'pages.signup', ['linkName' => 'signup']);
Route::view('/login', 'pages.login', ['linkName' => 'login']);
Route::controller(UserController::class)->group(function () {
    Route::post('/signup', 'store');
});
Route::get('/{nav}', function ($nav) {
    return view('layout.tab')->with('linkName', $nav);
});
