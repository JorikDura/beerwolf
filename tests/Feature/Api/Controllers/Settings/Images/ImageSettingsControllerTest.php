<?php

declare(strict_types=1);

use App\Models\Image;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Tests\Extensions\generateFakeFile;

describe('image settings controller tests', function (): void {
    beforeEach(function (): void {
        $this->user = User::factory()
            ->create();
    });

    it('upload image action', function (): void {
        Sanctum::actingAs($this->user);

        Storage::fake('images');

        $fakeImage = generateFakeFile();

        $response = postJson(
            uri: route(name: 'settings.image.store.v1'),
            data: [
                'image' => $fakeImage,
            ],
        );

        $response->assertSuccessful();

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    'id',
                    'userId',
                    'path',
                ],
            ],
        );

        $path = str_replace(
            search: '/storage/images/',
            replace: '',
            subject: $response->json('data.path'),
        );

        Storage::disk('images')
            ->assertExists($path);
    });

    it('delete image action', function (): void {
        Sanctum::actingAs($this->user);

        Storage::fake('images');

        $fakeImage = generateFakeFile();

        Storage::disk('images')
            ->putFileAs(
                path: $key = (string) $this->user->id,
                file: $fakeImage,
                name: 'test.jpg',
            );

        $path = "$key/test.jpg";

        Image::factory()
            ->create([
                'imageable_id' => $this->user->id,
                'imageable_type' => User::class,
                'user_id' => $this->user->id,
                'path' => $path,
                'extension' => 'jpg',
            ]);

        Storage::disk('images')
            ->assertExists($path);

        $response = deleteJson(
            uri: route(name: 'settings.image.destroy.v1'),
        );

        $response->assertSuccessful();

        $response->assertNoContent();

        Storage::disk('images')
            ->assertMissing($path);
    });
});
