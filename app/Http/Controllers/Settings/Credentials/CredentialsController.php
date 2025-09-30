<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Credentials;

use App\Actions\Credentials\UpdateCredentialsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Credentials\UpdateCredentialsRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

final class CredentialsController extends Controller
{
    /**
     * @param UpdateCredentialsRequest $request
     * @param UpdateCredentialsAction $action
     * @param User $user
     *
     * @return UserResource
     */
    public function update(
        UpdateCredentialsRequest $request,
        UpdateCredentialsAction $action,
        #[CurrentUser] User $user,
    ): UserResource {
        $user = $action(
            user: $user,
            attributes: $request->validated(),
        );

        return UserResource::make($user);
    }
}
