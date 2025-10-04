<?php

declare(strict_types=1);

namespace App\Actions\Images;

use App\Models\Image;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class GetImagesAction
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
        return Image::query()
            ->where(
                column: 'imageable_id',
                operator: '=',
                value: $modelId,
            )
            ->where(
                column: 'imageable_type',
                operator: '=',
                value: $modelType,
            )
            ->orderBy(
                column: 'created_at',
            )
            ->paginate();
    }
}
