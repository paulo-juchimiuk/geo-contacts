<?php

use App\Modules\Auth\Infrastructure\Adapter\In\Http\Controllers\AuthenticatedSessionController;
use App\Modules\Auth\Infrastructure\Adapter\In\Http\Controllers\EmailVerificationNotificationController;
use App\Modules\Auth\Infrastructure\Adapter\In\Http\Controllers\NewPasswordController;
use App\Modules\Auth\Infrastructure\Adapter\In\Http\Controllers\PasswordResetLinkController;
use App\Modules\Auth\Infrastructure\Adapter\In\Http\Controllers\RegisteredUserController;
use App\Modules\Auth\Infrastructure\Adapter\In\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
