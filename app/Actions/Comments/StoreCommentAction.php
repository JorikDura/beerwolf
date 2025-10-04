<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Actions\Images\StoreImagesAction;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class StoreCommentAction
{
    public function __construct(
        private StoreImagesAction $storeImagesAction,
    ) {
    }

    /**
     * @param int|Model $modelId
     * @param string $modelType
     * @param User $author
     * @param array $attributes
     *
     * @return Comment
     * @throws Throwable
     */
    public function __invoke(
        int|Model $modelId,
        string $modelType,
        User $author,
        array $attributes,
    ): Comment {
        if ($modelId instanceof Model) {
            $modelId = $modelId->getKey();
        }

        return DB::transaction(
            callback: function () use ($modelType, $modelId, $attributes, $author): Comment {
                $comment = new Comment();
                $comment->commentable_id = $modelId;
                $comment->commentable_type = $modelType;
                $comment->content = $attributes['content'] ?? null;
                $comment->comment_id = $attributes['commentId'] ?? null;
                $comment->author()->associate($author);
                $comment->save();

                /** @var Comment */
                return $this
                    ->storeImagesAction
                    ->__invoke(
                        model: $comment,
                        author: $author,
                        files: $attributes['images'],
                    );
            },
        );
    }
}
