<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use App\Models\Team;
use Illuminate\Support\Collection;

interface TeamRepository
{
    public function getTasks(int $user_id, int $team_id): Team;

    public function getMemberTeams(int $user_id): Collection;
}
