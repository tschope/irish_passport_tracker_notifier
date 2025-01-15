<?php

use App\Http\Controllers\ApplicationEmailController;

Route::post('/application-email', [ApplicationEmailController::class, 'store']);
Route::put('/application-email/{applicationId}', [ApplicationEmailController::class, 'update']);
Route::post('/unsubscribe', [ApplicationEmailController::class, 'unsubscribeForm']);
