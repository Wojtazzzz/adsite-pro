<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\TeamRepository;
use Modules\Task\Queries\UpdateTaskStatusCommand;

readonly class GetUserTeamsQueryHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    public function handle(GetUserTeamsQuery $query): Collection
    {
        return $this->team->getConnectedWithUsers($query->user_id);
    }
}
