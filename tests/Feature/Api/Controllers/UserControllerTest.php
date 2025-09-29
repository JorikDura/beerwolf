<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\getJson;

describe('user controller tests', function () {
    beforeEach(function () {
        $this->users = User::factory()
            ->count(5)
            ->create();
    });

    it('get all users', function () {
        $response = getJson(
            uri: route(
                name: 'UserIndex',
            ),
        );

        $response->assertSuccessful();

        $response->assertJsonCount(
            count: 5,
            key: 'data',
        );

        /** @var User $randomUser */
        $randomUser = $this->users->random();

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
            responseData: [
                'data' => [
                    '*' => [
                        'id' => $randomUser->id,
                        'name' => $randomUser->name,
                    ],
                ],
            ],
        );
    });

    it('get user by id', function () {
        /** @var User $randomUser */
        $randomUser = $this->users->random();

        $response = getJson(
            uri: route(
                name: 'UserShow',
                parameters: ['userId' => $randomUser->id],
            ),
        );

        $response->assertSuccessful();

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    'id',
                    'name',
                ],
            ],
            responseData: [
                'data' => [
                    'id' => $randomUser->id,
                    'name' => $randomUser->name,
                ],
            ],
        );
    });
});
