<?php

declare(strict_types=1);

namespace App\Actions\Images;

use App\Models\Image;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use function App\Extensions\Helpers\generateFilename;

final readonly class StoreImagesAction
{
    /**
     * @param Model $model
     * @param User $author
     * @param array $files
     *
     * @return Model
     */
    public function __invoke(
        Model $model,
        User $author,
        array $files,
    ): Model {
        abort_if(
            boolean: ! method_exists($model, 'images'),
            code: Response::HTTP_BAD_REQUEST,
        );

        $toInsert = [];
        $key = (string) $model->getKey();
        $now = now();
        $imagesDisk = Storage::disk('images');

        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $filename = generateFilename($file);

            $toInsert[] = [
                'user_id' => $author->getKey(),
                'imageable_id' => $model->getKey(),
                'imageable_type' => $model::class,
                'extension' => $file->getClientOriginalExtension(),
                'path' => "$key/$filename",
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $imagesDisk->putFileAs(
                path: $key,
                file: $file,
                name: $filename,
            );
        }

        try {
            Image::insert($toInsert);
        } catch (Exception) {
            foreach ($toInsert as $item) {
                $imagesDisk->delete($item['path']);
            }
        }

        return $model->load(['images']);
    }
}
