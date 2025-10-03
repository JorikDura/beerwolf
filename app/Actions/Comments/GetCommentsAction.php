<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class GetCommentsAction
{
    /**
     * @param int $modelId
     * @param string $modelType
     *
     * @return LengthAwarePaginator
     */
    public function __invoke(
        int $modelId,
        string $modelType,
    ): LengthAwarePaginator {
        return Comment::query()
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
            ->paginate();
    }
}
