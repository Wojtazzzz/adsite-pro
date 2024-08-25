<?php

declare(strict_types=1);

namespace Modules\Task\Queries;

use App\Models\Team;

class GetUserTasksQueryHandler
{
    public function handle(GetUserTasksQuery $query)
    {
        return Team::query()->with(['categories', 'categories.tasks'])->userRelated($query->user_id)->get();
    }
}
