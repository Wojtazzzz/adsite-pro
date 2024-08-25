<?php

declare(strict_types=1);

namespace Modules\Task\Repositories;

use App\Models\Team;
use Illuminate\Support\Collection;
use Modules\Task\Domain\TeamRepository;

class EloquentTeamRepository implements TeamRepository
{
    public function getUserTeamsWithTasks(int $user_id): Collection
    {
        return Team::query()->with(['categories', 'categories.tasks'])->userRelated($user_id)->get();
    }
}
