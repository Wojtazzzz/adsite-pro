<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use App\Models\Team;
use Modules\Task\Domain\Entities\Team as TeamEntity;
use Illuminate\Support\Collection;

interface TeamRepository
{
    public function getTasks(int $user_id, int $team_id): Team;

    public function getConnectedWithUsers(int $user_id): Collection;

    public function createTeam(int $user_id, TeamEntity $teamEntity);
}
