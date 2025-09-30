<?php

declare(strict_types=1);

namespace App\Http\Requests\Credentials;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateCredentialsRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'string', 'email', 'unique:users'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
