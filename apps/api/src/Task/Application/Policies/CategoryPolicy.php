<?php

declare(strict_types=1);

namespace Modules\Task\Application\Policies;

use App\Models\User;
use App\Models\Team;

class CategoryPolicy
{
    public function create(User $user, Team $team): bool
    {
        if ($user->id === $team->user_id) {
            return true;
        }

        return false;
    }
}
