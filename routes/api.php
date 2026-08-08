<?php

use App\Http\Controllers\Api\VenueApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('venue')->group(function () {
    Route::get('/snapshot', [VenueApiController::class, 'snapshot']);
    Route::get('/pois', [VenueApiController::class, 'pois']);
    Route::get('/operations', [VenueApiController::class, 'operations']);
    Route::get('/analytics', [VenueApiController::class, 'analytics']);
    Route::get('/route', [VenueApiController::class, 'route']);
    Route::post('/poi/update-transform', [VenueApiController::class, 'updatePoiTransform']);
});
