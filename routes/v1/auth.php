<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthorizationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::post('auth/registration', RegistrationController::class);
Route::post('auth/login', AuthorizationController::class);
Route::post('auth/logout', LogoutController::class)
    ->middleware('auth:sanctum');
