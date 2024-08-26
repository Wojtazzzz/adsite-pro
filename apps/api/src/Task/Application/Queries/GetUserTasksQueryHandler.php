<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\TeamRepository;
use Modules\Task\Queries\UpdateTaskStatusCommand;

readonly class GetUserTasksQueryHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    public function handle(GetUserTasksQuery $query): Collection
    {
        return $this->team->getUserTeamsWithTasks($query->user_id);
    }
}
