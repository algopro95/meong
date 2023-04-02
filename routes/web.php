<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
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

Route::get('/', function () {
    return view('web');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'perform'])->name('logout.perform');

    Route::get('/email/verify', [App\Http\Controllers\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
    Route::post('/email/resend', [App\Http\Controllers\VerificationController::class, 'resend'])->name('verification.resend');
});

Route::group(['middleware' => ['auth','verified']], function() {
    /**
     * Dashboard Routes
     */
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
});

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
