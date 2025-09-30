<?php

declare(strict_types=1);

use function Pest\Laravel\postJson;

describe('registration controller tests', function (): void {
    it('registration action test', function (): void {
        $credentials = [
            'name' => 'testUser',
            'email' => 'testemail@email.com',
            'password' => 'testPassword1234',
            'password_confirmation' => 'testPassword1234',
        ];

        $response = postJson(
            uri: route(name: 'auth.registration.v1'),
            data: $credentials
        );

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    });
});
