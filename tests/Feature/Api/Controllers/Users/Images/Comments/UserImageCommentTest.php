<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Tests\Extensions\generateFakeFiles;

describe('user image comment controller tests', function (): void {
    beforeEach(function (): void {
        $this->user = User::factory()
            ->create();

        $this->image = Image::factory()
            ->create([
                'user_id' => $this->user->id,
                'imageable_id' => $this->user->id,
                'imageable_type' => User::class,
            ]);

        $this->comments = Comment::factory()
            ->count(5)
            ->create([
                'author_id' => $this->user->id,
                'commentable_id' => $this->image->id,
                'commentable_type' => Image::class,
            ]);
    });

    it('get all image comments', function (): void {
        $response = getJson(
            uri: route(
                name: 'users.images.comments.index.v1',
                parameters: [
                    'userId' => $this->user->id,
                    'imageId' => $this->image->id,
                ],
            ),
        );

        $response->assertSuccessful();

        $response->assertJsonCount(
            count: 5,
            key: 'data',
        );

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    '*' => [
                        'id',
                        'author',
                        'commentId',
                        'content',
                        'images',
                        'createdAt',
                        'updatedAt',
                    ],
                ],
            ],
        );
    });

    it('store image comment', function (): void {
        Storage::fake('images');
        Sanctum::actingAs($this->user);

        $fakeImages = generateFakeFiles();

        /** @var Comment $randomComment */
        $randomComment = $this->comments->random();

        $response = postJson(
            uri: route(
                name: 'users.images.comments.store.v1',
                parameters: [
                    'userId' => $this->user->id,
                    'imageId' => $this->image->id,
                ],
            ),
            data: [
                'commentId' => $randomComment->id,
                'content' => fake()->text,
                'images' => $fakeImages,
            ],
        );

        $response->assertSuccessful();

        $response->assertJsonStructure(
            structure: [
                'data' => [
                    'id',
                    'author',
                    'commentId',
                    'content',
                    'images',
                    'createdAt',
                    'updatedAt',
                ],
            ],
        );

        foreach ($response->json('data.images') as $image) {
            $path = str_replace(
                search: '/storage/images/',
                replace: '',
                subject: $image['path'],
            );

            Storage::disk('images')
                ->assertExists($path);
        }
    });

    it('users deletes his own image comment', function (): void {
        $comment = Comment::factory()
            ->create([
                'author_id' => $this->user->id,
                'commentable_id' => $this->image->id,
                'commentable_type' => Image::class,
            ]);

        Sanctum::actingAs($this->user);

        $response = deleteJson(
            uri: route(
                name: 'users.images.comments.destroy.v1',
                parameters: [
                    'userId' => $this->user->id,
                    'imageId' => $this->image->id,
                    'comment' => $comment->id,
                ],
            ),
        );

        $response->assertSuccessful();
    });
});
