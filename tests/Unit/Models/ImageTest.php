<?php

declare(strict_types=1);

use App\Models\Image;

describe('image model test', function (): void {
    it('has keys', function (): void {
        $image = Image::factory()
            ->create()
            ->fresh();

        expect($image)
            ->toBeInstanceOf(Image::class)
            ->toHaveKeys([
                'id',
                'imageable_id',
                'imageable_type',
                'path',
                'extension',
                'created_at',
                'updated_at',
            ]);
    });
});
