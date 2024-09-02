<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\TeamRepository;
use Modules\Task\Domain\Entities\Team as TeamEntity;

class EloquentTeamRepository implements TeamRepository
{
    public function getTeamTasks(int $teamId, int $userId, bool $onlyUserTasks): Team
    {
        return Team::query()
            ->with([
                'categories',
                'categories.tasks' => function ($query) use ($userId, $onlyUserTasks) {
                    $query->when($onlyUserTasks, function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    });
                },
                'categories.tasks.user',
            ])
            ->where('id', $teamId)
            ->userRelated($userId)
            ->first([
                'id',
                'name'
            ]);
    }

    public function getConnectedWithUsers(int $userId): Collection
    {
        return Team::query()
            ->userRelated($userId)
            ->get([
                'id',
                'name',
                'user_id'
            ]);
    }

    public function getUserOwnedTeams(int $userId): Collection
    {
        return Team::query()
            ->where('user_id', $userId)
            ->get([
                'id',
                'name'
            ]);
    }

    public function createTeam(int $userId, TeamEntity $teamEntity): void
    {
        Team::query()->create([
            'user_id' => $userId,
            'name' => $teamEntity->name
        ]);
    }

    public function delete(int $teamId): void
    {
        Team::query()->where('id', $teamId)->delete();
    }

    public function updateName(int $teamId, string $newName): void
    {
        Team::query()
            ->where('id', $teamId)
            ->update(['name' => $newName]);
    }

    public function addMember(int $teamId, int $userId): void
    {
        $user = User::findOrFail($userId);

        Team::query()
            ->findOrFail($teamId)
            ->users()
            ->attach($user);
    }
}
