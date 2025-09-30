<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class GetUsersAction
{
    /**
     * @return LengthAwarePaginator
     */
    public function __invoke(): LengthAwarePaginator
    {
        return User::query()
            ->with(['image'])
            ->select([
                'id',
                'name',
            ])
            ->paginate();
    }
}
