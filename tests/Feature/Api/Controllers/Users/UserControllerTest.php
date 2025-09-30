<?php

declare(strict_types=1);

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\getJson;

describe('user controller tests', function (): void {
    beforeEach(function (): void {
        $this->users = User::factory()
            ->count(5)
            ->create();
    });

    it('get all users', function (): void {
        $response = getJson(
            uri: route(
                name: 'users.index.v1',
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
                        'image',
                    ],
                ],
            ],
            responseData: [
                'data' => [
                    '*' => [
                        'id' => $randomUser->id,
                        'name' => $randomUser->name,
                        'image' => null,
                    ],
                ],
            ],
        );
    });

    it('get user by id', function (): void {
        /** @var User $randomUser */
        $randomUser = $this->users->random();

        Storage::fake('images');

        $fakeImage = UploadedFile::fake()
            ->image(
                name: 'test.jpg',
                width: 200,
                height: 200,
            );

        Storage::disk('images')
            ->putFileAs(
                path: $key = (string) $randomUser->id,
                file: $fakeImage,
                name: 'test.jpg',
            );

        $path = "$key/test.jpg";

        /** @var Image $image */
        $image = Image::factory()
            ->create([
                'imageable_id' => $randomUser->id,
                'imageable_type' => User::class,
                'user_id' => $randomUser->id,
                'path' => $path,
                'extension' => 'jpg',
            ]);

        $response = getJson(
            uri: route(
                name: 'users.show.v1',
                parameters: ['userId' => $randomUser->id],
            ),
        );

        $response->assertSuccessful();

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    'id',
                    'name',
                    'image',
                ],
            ],
            responseData: [
                'data' => [
                    'id' => $randomUser->id,
                    'name' => $randomUser->name,
                    'image' => [
                        'id' => $image->id,
                        'userId' => $image->user_id,
                        'path' => Storage::url("images/$image->path"),
                    ],
                ],
            ],
        );
    });
});
