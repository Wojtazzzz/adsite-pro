<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\Team;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\TeamRepository;

class EloquentTeamRepository implements TeamRepository
{
    public function getUserTeamsWithTasks(int $user_id): Collection
    {
        return Team::query()
            ->with([
                'categories:id,name,team_id',
                'categories.tasks:id,category_id,name,description,estimation,status,created_at'
            ])
            ->userRelated($user_id)
            ->get([
                'id',
                'name'
            ]);
    }
}
