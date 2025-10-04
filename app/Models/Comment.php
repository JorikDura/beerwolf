<?php

declare(strict_types=1);

namespace App\Models;

use App\Extensions\Traits\HasImages;
use App\Policies\CommentPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Override;

#[UsePolicy(CommentPolicy::class)]
final class Comment extends Model
{
    use HasFactory;
    use HasImages;

    /**
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'author_id',
        );
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(self::class);
    }

    /**
     * @return null|bool
     */
    #[Override]
    public function delete(): ?bool
    {
        $this->deleteImages();

        return parent::delete();
    }
}
