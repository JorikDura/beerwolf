<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;

final readonly class RegistrationAction
{
    /**
     * @param array $attributes
     *
     * @return User
     */
    public function __invoke(array $attributes): User
    {
        $user = new User();
        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->password = $attributes['password'];
        $user->save();

        event(new Registered($user));

        return $user;
    }
}
