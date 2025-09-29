<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;

final readonly class GetUserByIdAction
{
    /**
     * @param int $userId
     *
     * @return User
     */
    public function __invoke(int $userId): User
    {
        return User::query()
            ->select([
                'id',
                'name',
            ])
            ->findOrFail($userId);
    }
}
