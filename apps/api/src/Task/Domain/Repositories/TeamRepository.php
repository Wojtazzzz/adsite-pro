<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use App\Models\Team;
use Modules\Task\Domain\Entities\Team as TeamEntity;
use Illuminate\Support\Collection;

interface TeamRepository
{
    public function getTasks(int $userId, int $teamId): Team;

    public function getConnectedWithUsers(int $userId): Collection;

    public function createTeam(int $userId, TeamEntity $teamEntity);

    public function delete(int $teamId);

    public function updateName(int $teamId, string $newName);
}
