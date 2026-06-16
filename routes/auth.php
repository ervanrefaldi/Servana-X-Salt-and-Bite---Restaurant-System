<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CustomForgotPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
| Route untuk user yang belum login.
*/

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | Custom Forgot Password dengan Kode OTP
    |--------------------------------------------------------------------------
    */

    Route::get('forgot-password', [CustomForgotPasswordController::class, 'showEmailForm'])
        ->name('password.request');

    Route::post('forgot-password/send-code', [CustomForgotPasswordController::class, 'sendCode'])
        ->name('password.send.code');

    Route::get('forgot-password/verify-code', [CustomForgotPasswordController::class, 'showCodeForm'])
        ->name('password.code.form');

    Route::post('forgot-password/verify-code', [CustomForgotPasswordController::class, 'verifyCode'])
        ->name('password.code.verify');

    Route::get('forgot-password/reset', [CustomForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset.form');

    Route::post('forgot-password/reset', [CustomForgotPasswordController::class, 'resetPassword'])
        ->name('password.reset.update');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
| Route untuk user yang sudah login.
*/

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});