<?php

declare(strict_types=1);

namespace App\Extensions\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait HasImages
{
    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(
            related: Image::class,
            name: 'imageable',
        );
    }

    /**
     * @return MorphOne
     */
    public function currentImage(): MorphOne
    {
        return $this
            ->morphOne(
                related: Image::class,
                name: 'imageable',
            )
            ->latestOfMany();
    }

    /**
     * @return void
     */
    public function deleteImages(): void
    {
        $this->loadMissing('images');

        /** @var Collection<array-key,Image> $images */
        $images = $this->images;
        $images->each(static function (Image $image): void {
            Storage::disk('images')
                ->delete($image->path);
        });
    }
}
