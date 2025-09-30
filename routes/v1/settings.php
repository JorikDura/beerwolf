<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\Credentials\CredentialsController;
use App\Http\Controllers\Settings\Image\ImageSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ImageSettingsController::class)->group(function () {
        Route::post('/settings/image', 'store')
            ->name('settings.image.store.v1');
        Route::delete('/settings/image', 'destroy')
            ->name('settings.image.destroy.v1');
    });

    Route::controller(CredentialsController::class)->group(function () {
        Route::match(['put', 'patch'], '/settings/credentials', 'update')
            ->name('settings.credentials.v1');
    });
});
