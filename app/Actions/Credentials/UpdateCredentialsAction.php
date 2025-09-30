<?php

declare(strict_types=1);

namespace App\Actions\Credentials;

use App\Models\User;

final readonly class UpdateCredentialsAction
{
    /**
     * @param User $user
     * @param array $attributes
     *
     * @return User
     */
    public function __invoke(User $user, array $attributes): User
    {
        $user->update($attributes);

        return $user->load([
            'image',
        ]);
    }
}
