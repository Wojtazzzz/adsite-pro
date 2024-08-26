<?php

declare(strict_types=1);

namespace Modules\Task\Application\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function updateStatus(User $user, Task $task): bool
    {
        if ($user->id === $task->id) {
            return true;
        }

        $team_owner_id = 1;

        if ($user->id === $team_owner_id) {
            return true;
        }

        return false;
    }
}
