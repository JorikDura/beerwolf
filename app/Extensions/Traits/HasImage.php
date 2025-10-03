<?php

declare(strict_types=1);

namespace App\Extensions\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasImage
{
    /**
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(
            related: Image::class,
            name: 'imageable',
        );
    }
}
