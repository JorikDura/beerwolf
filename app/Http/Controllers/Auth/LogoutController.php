<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LogoutAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;

final class LogoutController extends Controller
{
    /**
     * @param User $user
     * @param LogoutAction $action
     *
     * @return Response
     */
    public function __invoke(
        #[CurrentUser] User $user,
        LogoutAction $action,
    ): Response {
        $action($user);

        return response()->noContent();
    }
}
