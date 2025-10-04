<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users\Images\Comments;

use App\Actions\Comments\DeleteCommentByIdAction;
use App\Actions\Comments\GetCommentsAction;
use App\Actions\Comments\StoreCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Resources\Comments\CommentResource;
use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

final class UserImageCommentController extends Controller
{
    /**
     * @param int $userId
     * @param int $imageId
     * @param GetCommentsAction $action
     *
     * @return AnonymousResourceCollection
     */
    public function index(
        int $userId,
        int $imageId,
        GetCommentsAction $action,
    ): AnonymousResourceCollection {
        $comments = $action(
            modelId: $imageId,
            modelType: Image::class,
        );

        return CommentResource::collection($comments);
    }

    /**
     * @param StoreCommentRequest $request
     * @param int $userId
     * @param int $imageId
     * @param StoreCommentAction $action
     * @param User $user
     *
     * @return CommentResource
     * @throws Throwable
     */
    public function store(
        StoreCommentRequest $request,
        int $userId,
        int $imageId,
        StoreCommentAction $action,
        #[CurrentUser] User $user,
    ): CommentResource {
        $comment = $action(
            modelId: $imageId,
            modelType: Image::class,
            author: $user,
            attributes: $request->validated(),
        );

        return CommentResource::make($comment);
    }

    /**
     * @param int $userId
     * @param int $imageId
     * @param Comment $comment
     * @param DeleteCommentByIdAction $action
     *
     * @return Response
     */
    public function destroy(
        int $userId,
        int $imageId,
        Comment $comment,
        DeleteCommentByIdAction $action,
    ): Response {
        $action(
            commentId: $comment,
            modelId: $imageId,
            modelType: Image::class,
        );

        return response()->noContent();
    }
}
