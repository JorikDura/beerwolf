<?php

declare(strict_types=1);

use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index.v1');
    Route::get('/users/{userId}', 'show')->name('users.show.v1');
});
