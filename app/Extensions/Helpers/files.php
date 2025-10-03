<?php

declare(strict_types=1);

namespace App\Extensions\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @param UploadedFile $file
 * @param int $maxLength
 *
 * @return string
 */
function generateFilename(
    UploadedFile $file,
    int $maxLength = 12,
): string {
    return Str::random(length: $maxLength) . '.' . $file->extension();
}
