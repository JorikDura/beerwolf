<?php

declare(strict_types=1);

namespace App\Extensions\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
}
