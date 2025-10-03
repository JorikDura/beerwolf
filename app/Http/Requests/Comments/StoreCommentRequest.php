<?php

declare(strict_types=1);

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

final class StoreCommentRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'commentId' => ['sometimes', 'nullable', 'int', 'exists:comments,id'],
            'content' => ['sometimes', 'nullable', 'string', 'min:1', 'max:512'],
            'images' => ['sometimes', 'nullable', 'array', 'min:1', 'max:10'],
            'images.*' => ['sometimes', 'nullable', 'image', 'mimes:jpg,bmp,png,jpeg,gif', 'max:10240'],
        ];
    }
}
