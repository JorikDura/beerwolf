<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'imageable_id' => $this->faker->randomNumber(),
            'imageable_type' => $this->faker->word(),
            'path' => $this->faker->word(),
            'extension' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
