<?php

declare(strict_types=1);

namespace App\Http\Resources\Users;

use App\Http\Resources\Images\ImageResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
final class UserResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->relationLoaded('currentImage')
                ? ImageResource::make($this->currentImage)
                : null,
        ];
    }
}
