<?php

declare(strict_types=1);

namespace Tests\Extensions;

use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;

/**
 * @param string $filename
 * @param int $width
 * @param int $height
 *
 * @return File
 */
function generateFakeFile(
    string $filename = 'image.jpg',
    int $width = 200,
    int $height = 200,
): File {
    return UploadedFile::fake()
        ->image(
            name: $filename,
            width: $width,
            height: $height,
        );
}

/**
 * @param int $width
 * @param int $height
 * @param null|int $fileCount
 *
 * @return array<array-key, UploadedFile>
 */
function generateFakeFiles(
    int $width = 200,
    int $height = 200,
    ?int $fileCount = null,
): array {
    $fileCount ??= fake()->numberBetween(
        int1: 1,
        int2: 10,
    );

    $files = [];

    for ($i = 0; $i < $fileCount; $i++) {
        $files[] = generateFakeFile(
            filename: "test$i.jpg",
            width: $width,
            height: $height,
        );
    }

    return $files;
}
