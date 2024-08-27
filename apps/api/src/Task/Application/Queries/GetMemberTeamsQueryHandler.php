<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\TeamRepository;
use Modules\Task\Queries\UpdateTaskStatusCommand;

readonly class GetMemberTeamsQueryHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    public function handle(GetMemberTeamsQuery $query): Collection
    {
        return $this->team->getMemberTeams($query->user_id);
    }
}
