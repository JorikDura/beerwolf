<?php

declare(strict_types=1);

use App\Http\Controllers\Users\Comments\UserCommentController;
use App\Http\Controllers\Users\Images\Comments\UserImageCommentController;
use App\Http\Controllers\Users\Images\UserImageController;
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

Route::controller(UserImageController::class)->group(function (): void {
    Route::get('/users/{userId}/images', 'index')
        ->name('users.images.index.v1');
    Route::post('/users/{user}/images', 'store')
        ->middleware(['auth:sanctum', 'can:store,user'])
        ->name('users.images.store.v1');
    Route::delete('/users/{user}/images/{imageId}', 'destroy')
        ->middleware(['auth:sanctum', 'can:destroy,user'])
        ->name('users.images.destroy.v1');
});

Route::controller(UserImageCommentController::class)->group(function (): void {
    Route::get('/users/{userId}/images/{imageId}/comments', 'index')
        ->name('users.images.comments.index.v1');
    Route::post('/users/{userId}/images/{imageId}/comments', 'store')
        ->middleware('auth:sanctum')
        ->name('users.images.comments.store.v1');
    Route::delete('/users/{userId}/images/{imageId}/comments/{comment}', 'destroy')
        ->middleware(['auth:sanctum', 'can:destroy,comment'])
        ->name('users.images.comments.destroy.v1');
});
