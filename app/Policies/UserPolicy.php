<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $authorizedUser
     * @param User $user
     *
     * @return bool
     */
    public function store(User $authorizedUser, User $user): bool
    {
        return $authorizedUser->id === $user->id;
    }

    /**
     * @param User $authorizedUser
     * @param User $user
     *
     * @return bool
     */
    public function destroy(User $authorizedUser, User $user): bool
    {
        return $authorizedUser->id === $user->id;
    }
}
