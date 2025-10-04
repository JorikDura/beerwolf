<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     * @param Comment $comment
     *
     * @return null|bool
     */
    public function before(
        User $user,
        string $ability,
        Comment $comment,
    ): ?bool {
        if ($user->isAdmin()) {
            return true;
        }

        if (
            $comment->commentable_type === User::class
            && $comment->commentable_id === $user->id
        ) {
            return true;
        }

        return null;
    }

    /**
     * @param User $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function destroy(User $user, Comment $comment): bool
    {
        return $user->id === $comment->author_id;
    }
}
