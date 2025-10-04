<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

final readonly class DeleteCommentByIdAction
{
    /**
     * @param int|Model $commentId
     * @param int|Model $modelId
     * @param string $modelType
     *
     * @return void
     */
    public function __invoke(
        int|Model $commentId,
        int|Model $modelId,
        string $modelType,
    ): void {
        if ($commentId instanceof Model) {
            $commentId = $commentId->getKey();
        }

        if ($modelId instanceof Model) {
            $modelId = $modelId->getKey();
        }

        $comment = Comment::query()
            ->with(['images'])
            ->where(
                column: 'commentable_id',
                operator: '=',
                value: $modelId,
            )
            ->where(
                column: 'commentable_type',
                operator: '=',
                value: $modelType,
            )
            ->findOrFail($commentId);

        $comment->delete();
    }
}
