<?php

use App\Http\Controllers\ApplicationEmailController;

Route::post('/application-email', [ApplicationEmailController::class, 'store']);
Route::post('/getDetails', [ApplicationEmailController::class, 'getDetails']);
Route::put('/application-email/{applicationId}', [ApplicationEmailController::class, 'update']);
Route::post('/unsubscribe', [ApplicationEmailController::class, 'unsubscribeForm']);
