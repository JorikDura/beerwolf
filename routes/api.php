<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require base_path('routes/v1/auth.php');
    require base_path('routes/v1/users.php');
    require base_path('routes/v1/settings.php');
});
