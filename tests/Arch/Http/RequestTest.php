<?php

declare(strict_types=1);

use Illuminate\Foundation\Http\FormRequest;

arch('requests')
    ->expect('App\Http\Requests')
    ->toBeClasses()
    ->toExtend(FormRequest::class)
    ->toHaveSuffix('Request');
