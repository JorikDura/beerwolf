<?php

declare(strict_types=1);

namespace App\Http\Requests\Images;

use Illuminate\Foundation\Http\FormRequest;

final class ImageRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,bmp,png,jpeg,gif', 'max:10240'],
        ];
    }
}
