<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmailController;
use App\Http\Controllers\Web\HomeController;
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

//Autenticación del usuario.
Route::controller(AuthController::class)->middleware('RedirectIfAuthenticated')->group(function () {
    Route::get('/register', 'registerForm')->name('register.form');
    Route::get('/log-in', 'loginForm')->name('login.form');
    Route::get('/verification-code', [AuthController::class, 'twoFactorForm'])->name('twofactor.form');
    Route::middleware(['throttle:web'])->group(function () {
        Route::post('/log-in', 'login')->name('login.submit');
        Route::post('/verification-code/verify', 'verifyTwoFactor')->name('twofactor.verify');
        Route::post('/register', 'register')->name('register.submit');
    });
});

//Activar cuenta.
Route::get('/activate-account', [EmailController::class, 'activateAccount'])->name('activate.account');

//Usuario autenticado.
Route::middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->middleware('nocache')->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
