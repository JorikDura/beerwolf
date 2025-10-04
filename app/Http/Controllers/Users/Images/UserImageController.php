<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users\Images;

use App\Actions\Images\DeleteImageByIdAction;
use App\Actions\Images\GetImagesAction;
use App\Actions\Images\StoreImageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Images\ImageRequest;
use App\Http\Resources\Images\ImageResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

final class UserImageController extends Controller
{
    /**
     * @param int $userId
     * @param GetImagesAction $action
     *
     * @return AnonymousResourceCollection
     */
    public function index(
        int $userId,
        GetImagesAction $action,
    ): AnonymousResourceCollection {
        $images = $action(
            modelId: $userId,
            modelType: User::class,
        );

        return ImageResource::collection($images);
    }


    /**
     * @param ImageRequest $request
     * @param User $user
     * @param StoreImageAction $action
     *
     * @return ImageResource
     * @throws Throwable
     */
    public function store(
        ImageRequest $request,
        User $user,
        StoreImageAction $action,
    ): ImageResource {
        $image = $action(
            file: $request->validated('image'),
            user: $user,
        );

        return ImageResource::make($image);
    }

    /**
     * @param User $user
     * @param int $imageId
     * @param DeleteImageByIdAction $action
     *
     * @return Response
     */
    public function destroy(
        User $user,
        int $imageId,
        DeleteImageByIdAction $action,
    ): Response {
        $action(
            imageId: $imageId,
            modelId: $user,
            modelType: User::class,
        );

        return response()->noContent();
    }
}
