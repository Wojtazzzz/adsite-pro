<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use App\Models\Team;
use Modules\Task\Domain\Entities\Team as TeamEntity;
use Illuminate\Support\Collection;

interface TeamRepository
{
    public function getTeamTasks(int $teamId, int $userId, bool $onlyUserTasks): Team;

    public function getConnectedWithUsers(int $userId): Collection;

    public function createTeam(int $userId, TeamEntity $teamEntity): void;

    public function delete(int $teamId): void;

    public function updateName(int $teamId, string $newName): void;

    public function addMember(int $teamId, int $userId): void;
}
