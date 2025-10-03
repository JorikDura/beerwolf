<?php

declare(strict_types=1);

use App\Models\Comment;

describe('comment model test', function (): void {
    it('has keys', function (): void {
        /** @var Comment $user */
        $user = Comment::factory()
            ->create()
            ->fresh();

        expect($user)
            ->toBeInstanceOf(Comment::class)
            ->toHaveKeys([
                'id',
                'author_id',
                'comment_id',
                'commentable_id',
                'commentable_type',
                'content',
                'created_at',
                'updated_at',
            ]);
    });
});
