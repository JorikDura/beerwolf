<?php

declare(strict_types=1);

use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Tests\Extensions\generateFakeFile;

describe('user image controller tests', function (): void {
    beforeEach(function (): void {
        $this->user = User::factory()
            ->create();

        $this->anotherUser = User::factory()
            ->create();

        Storage::fake('images');

        $fakeImage = generateFakeFile();

        $key = (string) $this->user->id;

        $this->image = Image::factory()
            ->create([
                'user_id' => $this->user->id,
                'imageable_id' => $this->user->id,
                'imageable_type' => User::class,
                'path' => "$key/test.jpg",
            ]);

        Storage::disk('images')
            ->putFileAs(
                path: $key,
                file: $fakeImage,
                name: 'test.jpg',
            );
    });

    it('get user images', function (): void {
        $response = getJson(
            uri: route(
                name: 'users.images.index.v1',
                parameters: [
                    'userId' => $this->user->id,
                ],
            ),
        );

        $response->assertSuccessful();

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    '*' => [
                        'id',
                        'userId',
                        'path',
                    ],
                ],
            ],
        );
    });

    it('user store image', function (): void {
        Storage::fake('images');
        Sanctum::actingAs($this->user);

        $fakeImage = generateFakeFile();

        $response = postJson(
            uri: route(
                name: 'users.images.store.v1',
                parameters: [
                    'user' => $this->user->id,
                ],
            ),
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

    it('another user can not store image to another users profile', function (): void {
        Storage::fake('images');
        Sanctum::actingAs($this->anotherUser);

        $fakeImage = generateFakeFile();

        $response = postJson(
            uri: route(
                name: 'users.images.store.v1',
                parameters: [
                    'user' => $this->user->id,
                ],
            ),
            data: [
                'image' => $fakeImage,
            ],
        );

        $response->assertForbidden();
    });

    it('user deletes image', function (): void {
        Storage::fake('images');
        Sanctum::actingAs($this->user);

        Storage::fake('images');

        $fakeImage = generateFakeFile();

        $key = (string) $this->user->id;

        $image = Image::factory()
            ->create([
                'user_id' => $this->user->id,
                'imageable_id' => $this->user->id,
                'imageable_type' => User::class,
                'path' => $path = "$key/test.jpg",
            ]);

        Storage::disk('images')
            ->putFileAs(
                path: $key,
                file: $fakeImage,
                name: 'test.jpg',
            );

        $response = deleteJson(
            uri: route(
                name: 'users.images.destroy.v1',
                parameters: [
                    'user' => $this->user->id,
                    'imageId' => $image->id,
                ],
            ),
        );

        $response->assertSuccessful();

        Storage::disk('images')
            ->assertMissing($path);
    });

    it('another user can not delete image from another users profile', function (): void {
        Storage::fake('images');
        Sanctum::actingAs($this->anotherUser);

        Storage::fake('images');

        $fakeImage = generateFakeFile();

        $key = (string) $this->user->id;

        $image = Image::factory()
            ->create([
                'user_id' => $this->user->id,
                'imageable_id' => $this->user->id,
                'imageable_type' => User::class,
                'path' => $path = "$key/test.jpg",
            ]);

        Storage::disk('images')
            ->putFileAs(
                path: $key,
                file: $fakeImage,
                name: 'test.jpg',
            );

        $response = deleteJson(
            uri: route(
                name: 'users.images.destroy.v1',
                parameters: [
                    'user' => $this->user->id,
                    'imageId' => $image->id,
                ],
            ),
        );

        $response->assertForbidden();

        Storage::disk('images')
            ->assertExists($path);
    });
});
