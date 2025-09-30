<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\CreateTokenAction;
use App\Actions\Auth\RegistrationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\Auth\TokenResource;

final class RegistrationController extends Controller
{
    /**
     * @param RegistrationRequest $request
     * @param RegistrationAction $registrationAction
     * @param CreateTokenAction $createTokenAction
     *
     * @return TokenResource
     */
    public function __invoke(
        RegistrationRequest $request,
        RegistrationAction $registrationAction,
        CreateTokenAction $createTokenAction,
    ): TokenResource {
        $user = $registrationAction($request->validated());
        $token = $createTokenAction($user);

        return TokenResource::make($token);
    }
}
