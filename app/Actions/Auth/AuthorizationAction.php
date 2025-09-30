<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthorizationAction
{
    /**
     * @param array $attributes
     *
     * @return User
     */
    public function __invoke(array $attributes): User
    {
        abort_if(
            boolean: ! auth()->attempt($attributes),
            code: Response::HTTP_UNPROCESSABLE_ENTITY
        );

        return auth()->user();
    }
}
