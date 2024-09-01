<?php

declare(strict_types=1);

namespace Modules\Task\Application\Policies;

use App\Models\Team;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function store(?User $user, Team $team): bool
    {
        if (!$user) {
            return false;
        }

        if ($team->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function updateStatus(?User $user, Task $task): bool
    {
        if ($user->id === $task->user_id) {
            return true;
        }

        if ($user->id === $task->category->team->user_id) {
            return true;
        }

        return false;
    }
}
