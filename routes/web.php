<?php
use App\Http\Controllers\addController;
use App\Http\Controllers\buyController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\editController;
use App\Http\Controllers\getCarDetails;
use App\Http\Controllers\getMakes;
use App\Http\Controllers\loginController;
use App\Http\Controllers\sellController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
    Route::get('/details/{id}/offer', function ($id) {
        return redirect()->route('details', ['id' => $id]);
    })->name('details.offer')->middleware(['auth', 'account.verified']);
    Route::get('/details/{id}/checkout', function ($id) {
        return redirect()->route('details', ['id' => $id]);
    })->name('details.checkout')->middleware(['auth', 'account.verified']);
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

Route::get('/account/{id}', [UserController::class, 'index']);
Route::post('/api/carDetails/v2', [getCarDetails::class, 'getMaker']);
Route::get('/api/carDetails/v2/{maker}', [getCarDetails::class, 'getModel']);
Route::get('/edit/{id}', [editController::class, 'index'])->name('edit')->middleware('auth');
Route::post('/edit/{id}', [editController::class, 'save'])->name('edit.save')->middleware('auth');
Route::get('verify', function () {
    return view('pages.verify', ['user' => Auth::user()]);
})->name('verify')->middleware('auth');

Route::get('verify/email', [EmailVerificationController::class, 'show'])->name('verify.email');
Route::post('verify/email/send', [EmailVerificationController::class, 'send'])->name('verify.email.send')->middleware('auth');
Route::get('verify/email/confirm', [EmailVerificationController::class, 'confirm'])->name('verify.email.confirm');

Route::get('verify/phone', function () {
    return view('pages.verify.phone', ['user' => Auth::user()]);
})->name('verify.phone')->middleware('auth');

Route::get('verify/document', function () {
    return view('pages.verify.document', ['user' => Auth::user()]);
})->name('verify.document')->middleware('auth');