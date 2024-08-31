<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\UserRepository;

class EloquentUserRepository implements UserRepository
{
    public function getTeamMembers(int $teamId): Collection
    {
        return User::query()
            ->teamRelated($teamId)
            ->get([
                'id',
                'name'
            ]);
    }

    public function getTasksByTeamFromCurrentMonth(int $userId, int $teamId): Collection
    {
        return User::findOrFail($userId)
            ->tasks()
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->get([
                'id',
                'name',
                'description',
                'status',
                'estimation',
                'category_id',
                'user_id'
            ]);
    }
}
