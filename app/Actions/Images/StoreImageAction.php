<?php

declare(strict_types=1);

namespace App\Actions\Images;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

use function App\Extensions\Helpers\generateFilename;

final readonly class StoreImageAction
{
    /**
     * @param UploadedFile $file
     * @param User $user
     * @param null|Model $model
     * @param null|string $filename
     *
     * @return Image
     * @throws Throwable
     */
    public function __invoke(
        UploadedFile $file,
        User $user,
        ?Model $model = null,
        ?string $filename = null,
    ): Image {
        $model ??= $user;

        abort_if(
            boolean: ! method_exists($model, 'image'),
            code: Response::HTTP_METHOD_NOT_ALLOWED,
        );

        /** @var ?Image $existingImage */
        $existingImage = $model
            ->image()
            ->first();

        $existingImage?->delete();

        $filename ??= generateFilename($file);

        $key = (string) $model->getKey();

        $image = new Image();
        $image->imageable()->associate($model);
        $image->user()->associate($user);
        $image->path = "$key/$filename";
        $image->extension = $file->extension();
        $image->save();

        Storage::disk('images')
            ->putFileAs(
                path: $key,
                file: $file,
                name: $filename,
            );

        return $image;
    }
}
