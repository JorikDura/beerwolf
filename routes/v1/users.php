<?php

declare(strict_types=1);

use App\Http\Controllers\Users\Comments\UserCommentController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function (): void {
    Route::get('/users', 'index')->name('users.index.v1');
    Route::get('/users/{userId}', 'show')->name('users.show.v1');
});

Route::controller(UserCommentController::class)->group(function (): void {
    Route::get('/users/{userId}/comments', 'index')
        ->name('users.comments.index.v1');
    Route::post('/users/{userId}/comments', 'store')
        ->middleware('auth:sanctum')
        ->name('users.comments.store.v1');
});
