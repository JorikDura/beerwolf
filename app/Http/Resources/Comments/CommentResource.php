<?php

declare(strict_types=1);

namespace App\Http\Resources\Comments;

use App\Http\Resources\Images\ImageResource;
use App\Http\Resources\Users\UserResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
 */
final class CommentResource extends JsonResource
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
            'author' => $this->relationLoaded('author')
                ? UserResource::make($this->author)
                : null,
            'commentId' => $this->comment_id,
            'content' => $this->content,
            'images' => $this->relationLoaded('images')
                ? ImageResource::collection($this->images)
                : null,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
