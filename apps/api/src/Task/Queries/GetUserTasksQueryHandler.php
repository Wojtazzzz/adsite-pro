<?php

declare(strict_types=1);

namespace Modules\Task\Queries;

use Illuminate\Support\Collection;
use Modules\Task\Domain\TeamRepository;

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
