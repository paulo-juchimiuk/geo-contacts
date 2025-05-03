<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Contact\Infrastructure\Adapter\In\Http\Controllers\ContactController;
use Modules\Auth\Infrastructure\Adapter\In\Http\Controllers\{
    AuthenticatedSessionController,
    RegisteredUserController,
    PasswordResetLinkController,
    NewPasswordController,
    EmailVerificationNotificationController,
    VerifyEmailController
};

/* ---------- AUTH (API) ---------- */

Route::post('/login',    [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/register', [RegisteredUserController::class,      'store'])->name('register');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::post('/reset-password',  [NewPasswordController::class, 'store'])
    ->name('password.store');

/* Rotas que exigem token Sanctum */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::post('/email/verification-notification',
        [EmailVerificationNotificationController::class, 'store'])->name('verification.send');

    Route::get('/verify-email/{id}/{hash}',
        VerifyEmailController::class)->name('verification.verify');

    /* ---------- CONTACT ---------- */
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts',  [ContactController::class, 'index']);

    /* ---------- USER (debug) ---------- */
    Route::get('/user', fn (Request $request) => $request->user());
});
