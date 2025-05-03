<?php

use App\Modules\Contact\Infrastructure\Adapter\In\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts', [ContactController::class, 'index']);
});

require __DIR__.'/auth.php';
