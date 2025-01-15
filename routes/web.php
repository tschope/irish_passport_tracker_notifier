<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationEmailController;

Route::get('/', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/email/verify/{hash}', [ApplicationEmailController::class, 'verifyEmail'])->name('email.verify');
Route::get('/unsubscribe/{token}', [ApplicationEmailController::class, 'unsubscribe']);
