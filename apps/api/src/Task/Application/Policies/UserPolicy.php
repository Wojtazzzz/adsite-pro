<?php

declare(strict_types=1);

namespace Modules\Task\Application\Policies;

use App\Models\User;
use App\Models\Team;

class UserPolicy
{
    public function index(?User $user, Team $team): bool
    {
        if (!$user) {
            return false;
        }

        if ($team->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function details(?User $user, Team $team): bool
    {
        if (!$user) {
            return false;
        }

        if ($team->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
