<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use Illuminate\Support\Collection;

interface TeamRepository
{
    public function getTeamTasks(int $user_id, int $team_id): Collection;
}
