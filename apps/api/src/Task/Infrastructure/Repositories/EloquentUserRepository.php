<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\Team;
use App\Models\User;
use App\Models\Category;
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

    public function getTeamMembersDetails(int $teamId): Collection
    {
        $teamCategories = Category::query()
            ->where('team_id', $teamId)
            ->pluck('id');

        return User::query()
            ->withSum(['tasks as total_estimation' => fn($query) => $query->whereIn('category_id', $teamCategories)->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])],
                'estimation')
            ->withCount([
                'tasks' => function ($query) use ($teamCategories) {
                    $query->whereIn('category_id', $teamCategories)->whereBetween('created_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth()
                    ]);
                },
                'tasks as idle_tasks_count' => function ($query) use ($teamCategories) {
                    $query->whereIn('category_id', $teamCategories)->whereBetween('created_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth()
                    ])->where('status', 'IDLE');
                },
                'tasks as in_progress_tasks_count' => function ($query) use ($teamCategories) {
                    $query->whereIn('category_id', $teamCategories)->whereBetween('created_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth()
                    ])->where('status', 'IN_PROGRESS');
                },
                'tasks as completed_tasks_count' => function ($query) use ($teamCategories) {
                    $query->whereIn('category_id', $teamCategories)->whereBetween('created_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth()
                    ])->where('status', 'COMPLETED');
                }
            ])
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

    public function getByEmail(string $email): User
    {
        return User::query()
            ->where('email', $email)
            ->firstOrFail();
    }

    public function deleteTeam(int $userId, int $teamId): void
    {
        User::query()
            ->where('id', $userId)
            ->firstOrFail()
            ->teams()
            ->detach($teamId);
    }
}
