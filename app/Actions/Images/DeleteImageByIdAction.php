<?php

declare(strict_types=1);

namespace App\Actions\Images;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

final readonly class DeleteImageByIdAction
{
    /**
     * @param int $imageId
     * @param int|Model $modelId
     * @param string $modelType
     *
     * @return void
     */
    public function __invoke(
        int $imageId,
        int|Model $modelId,
        string $modelType,
    ): void {
        if ($modelId instanceof Model) {
            $modelId = $modelId->getKey();
        }

        /** @var Image $image */
        $image = Image::query()
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
            ->findOrFail($imageId);

        $image->delete();
    }
}
