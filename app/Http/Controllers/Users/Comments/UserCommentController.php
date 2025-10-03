<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users\Comments;

use App\Actions\Comments\GetCommentsAction;
use App\Actions\Comments\StoreCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Resources\Comments\CommentResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

final class UserCommentController extends Controller
{
    /**
     * @param int $userId
     * @param GetCommentsAction $action
     *
     * @return AnonymousResourceCollection
     */
    public function index(
        int $userId,
        GetCommentsAction $action,
    ): AnonymousResourceCollection {
        $comments = $action(
            modelId: $userId,
            modelType: User::class,
        );

        return CommentResource::collection($comments);
    }

    /**
     * @param StoreCommentRequest $request
     * @param int $userId
     * @param StoreCommentAction $action
     * @param User $user
     *
     * @return CommentResource
     * @throws Throwable
     */
    public function store(
        StoreCommentRequest $request,
        int $userId,
        StoreCommentAction $action,
        #[CurrentUser] User $user,
    ): CommentResource {
        $comment = $action(
            modelId: $userId,
            modelType: User::class,
            author: $user,
            attributes: $request->validated(),
        );

        return CommentResource::make($comment);
    }
}
