<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use Illuminate\Support\Collection;

interface UserRepository
{
    public function getTeamMembers(int $teamId): Collection;

    public function getTasksByTeamFromCurrentMonth(int $userId, int $teamId): Collection;
}
