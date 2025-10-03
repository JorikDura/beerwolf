<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Tests\Extensions\generateFakeFiles;

describe('user comment controller tests', function (): void {
    beforeEach(function (): void {
        $this->user = User::factory()
            ->create();

        $this->comments = Comment::factory()
            ->count(5)
            ->create([
                'author_id' => $this->user->id,
                'commentable_id' => $this->user->id,
                'commentable_type' => User::class,
            ]);
    });

    it('get user comments', function (): void {
        $response = getJson(
            uri: route(
                name: 'users.comments.index.v1',
                parameters: [
                    'userId' => $this->user->id,
                ],
            ),
        );

        $response->assertSuccessful();

        $response->assertJsonCount(
            count: $this->comments->count(),
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

    it('store user comment', function (): void {
        /** @var Comment $randomComment */
        $randomComment = $this->comments->random();

        Storage::fake('images');
        Sanctum::actingAs($this->user);

        $fakeFiles = generateFakeFiles();

        $response = postJson(
            uri: route(
                name: 'users.comments.store.v1',
                parameters: [
                    'userId' => $this->user->id,
                ],
            ),
            data: [
                'commentId' => $randomComment->id,
                'content' => fake()->text,
                'images' => $fakeFiles,
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

        /** @var array $file */
        foreach ($response->json('data.images') as $file) {
            $path = str_replace(
                search: '/storage/images/',
                replace: '',
                subject: $file['path'],
            );

            Storage::disk('images')
                ->assertExists($path);
        }
    });
});
