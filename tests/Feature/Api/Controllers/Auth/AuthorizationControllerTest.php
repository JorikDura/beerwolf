<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\postJson;

describe('authorization controller test', function (): void {
    beforeEach(function (): void {
        $this->user = User::factory()
            ->create([
                'password' => 'sigmaTestBurgerPassword',
            ]);
    });

    it('test login action', function (): void {
        $response = postJson(
            uri: route(
                name: 'auth.login.v1',
            ),
            data: [
                'email' => $this->user->email,
                'password' => 'sigmaTestBurgerPassword',
            ],
        );

        $response->assertSuccessful();

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    'token',
                ],
            ],
        );
    });
});
