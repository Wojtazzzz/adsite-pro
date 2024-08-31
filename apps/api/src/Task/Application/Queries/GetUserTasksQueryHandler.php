<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use App\Models\Team;
use Modules\Task\Domain\Repositories\TeamRepository;

readonly class GetUserTasksQueryHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    public function handle(GetUserTasksQuery $query): Team
    {
        return $this->team->getTeamTasks(
            teamId: $query->team->id,
            userId: $query->userId,
            onlyUserTasks: $query->userId !== $query->team->user_id,
        );
    }
}
