<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthorizationAction;
use App\Actions\Auth\CreateTokenAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthorizationRequest;
use App\Http\Resources\Auth\TokenResource;

final class AuthorizationController extends Controller
{
    /**
     * @param AuthorizationRequest $request
     * @param AuthorizationAction $authorizationAction
     * @param CreateTokenAction $createTokenAction
     *
     * @return TokenResource
     */
    public function __invoke(
        AuthorizationRequest $request,
        AuthorizationAction $authorizationAction,
        CreateTokenAction $createTokenAction,
    ): TokenResource {
        $user = $authorizationAction($request->validated());
        $token = $createTokenAction($user);

        return TokenResource::make($token);
    }
}
