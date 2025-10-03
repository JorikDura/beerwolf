<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'commentable_id' => $this->faker->randomNumber(),
            'commentable_type' => $this->faker->word(),
            'content' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'author_id' => User::factory(),
            'comment_id' => null,
        ];
    }
}
