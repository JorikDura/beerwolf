<?php

declare(strict_types=1);

namespace App\Actions\Images;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

final readonly class DeleteImageAction
{
    /**
     * @param Model $model
     *
     * @return void
     */
    public function __invoke(Model $model): void
    {
        abort_if(
            boolean: ! method_exists($model, 'image'),
            code: Response::HTTP_NOT_FOUND,
        );

        /** @var ?Image $image */
        $image = $model
            ->image()
            ->first();

        $image?->delete();
    }
}
