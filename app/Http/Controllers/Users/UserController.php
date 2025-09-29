<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Actions\Users\GetUserByIdAction;
use App\Actions\Users\GetUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class UserController extends Controller
{
    /**
     * @param GetUsersAction $action
     *
     * @return AnonymousResourceCollection
     */
    public function index(GetUsersAction $action): AnonymousResourceCollection
    {
        $users = $action();

        return UserResource::collection($users);
    }

    /**
     * @param int $userId
     * @param GetUserByIdAction $action
     *
     * @return UserResource
     */
    public function show(int $userId, GetUserByIdAction $action): UserResource
    {
        $user = $action($userId);

        return UserResource::make($user);
    }
}
