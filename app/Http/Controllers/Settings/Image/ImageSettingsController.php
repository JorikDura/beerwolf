<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Image;

use App\Actions\Images\DeleteImageAction;
use App\Actions\Images\StoreImageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Images\ImageRequest;
use App\Http\Resources\Images\ImageResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;
use Throwable;

final class ImageSettingsController extends Controller
{
    /**
     * @param ImageRequest $request
     * @param StoreImageAction $action
     * @param User $user
     *
     * @return ImageResource
     * @throws Throwable
     */
    public function store(
        ImageRequest $request,
        StoreImageAction $action,
        #[CurrentUser] User $user,
    ): ImageResource {
        $file = $request->validated('image');

        $image = $action(
            file: $file,
            user: $user,
        );

        return ImageResource::make($image);
    }

    /**
     * @param DeleteImageAction $action
     * @param User $user
     *
     * @return Response
     */
    public function destroy(
        DeleteImageAction $action,
        #[CurrentUser] User $user,
    ): Response {
        $action($user);

        return response()->noContent();
    }
}
