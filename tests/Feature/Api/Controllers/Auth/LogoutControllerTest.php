<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

describe('logout controller test', function (): void {
    beforeEach(function (): void {
        $this->user = User::factory()
            ->create();
    });

    it('test logout action', function (): void {
        Sanctum::actingAs($this->user);

        $response = postJson(
            uri: route(name: 'auth.logout.v1'),
        );

        $response->assertSuccessful();

        $response->assertNoContent();
    });
});
