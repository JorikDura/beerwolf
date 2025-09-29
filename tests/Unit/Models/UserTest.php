<?php

declare(strict_types=1);

use App\Models\User;

describe('user model test', function (): void {
    it('has keys', function (): void {
        /** @var User $user */
        $user = User::factory()
            ->create()
            ->fresh();

        expect($user)
            ->toBeInstanceOf(User::class)
            ->toHaveKeys([
                'id',
                'name'
            ]);
    });
});
