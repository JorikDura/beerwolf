<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\Credentials\CredentialsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(CredentialsController::class)->group(function () {
        Route::match(['put', 'patch'], '/settings/credentials', 'update')
            ->name('settings.credentials.v1');
    });
});
