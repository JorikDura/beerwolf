<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthorizationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::post('auth/registration', RegistrationController::class)
    ->name('auth.registration.v1');
Route::post('auth/login', AuthorizationController::class)
    ->name('auth.login.v1');
Route::post('auth/logout', LogoutController::class)
    ->middleware('auth:sanctum')
    ->name('auth.logout.v1');
