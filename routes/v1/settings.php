<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\Image\ImageSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ImageSettingsController::class)->group(function () {
        Route::post('/settings/image', 'store');
        Route::delete('/settings/image', 'destroy');
    });
});
