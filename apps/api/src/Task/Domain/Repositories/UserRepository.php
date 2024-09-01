<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function getTeamMembers(int $teamId): Collection;

    public function getTeamMembersDetails(int $teamId): Collection;

    public function getTasksByTeamFromCurrentMonth(int $userId, int $teamId): Collection;

    public function getByEmail(string $email): User;

    public function deleteTeam(int $userId, int $teamId): void;
}
