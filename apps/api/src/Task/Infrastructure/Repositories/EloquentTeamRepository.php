<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\TeamRepository;
use Modules\Task\Domain\Entities\Team as TeamEntity;

class EloquentTeamRepository implements TeamRepository
{
    public function getTasks(int $user_id, int $team_id): Team
    {
        return Team::query()
            ->with([
                'categories:id,name,team_id',
                'categories.tasks:id,category_id,name,description,estimation,status,created_at'
            ])
            ->where('id', $team_id)
            ->userRelated($user_id)
            ->first([
                'id',
                'name'
            ]);
    }

    public function getConnectedWithUsers(int $user_id): Collection
    {
        return Team::query()
            ->userRelated($user_id)
            ->get([
                'id',
                'name',
                'user_id'
            ]);
    }

    public function getUserOwnedTeams(int $user_id): Collection
    {
        return Team::query()
            ->where('user_id', $user_id)
            ->get([
                'id',
                'name'
            ]);
    }

    public function createTeam(int $user_id, TeamEntity $teamEntity): Team
    {
        return Team::query()->create([
            'user_id' => $user_id,
            'name' => $teamEntity->name
        ]);
    }
}
