<?php

declare(strict_types=1);

namespace Modules\Task\Application\Policies;

use App\Models\User;
use App\Models\Team;

class TeamPolicy
{
    public function delete(User $user, Team $team): bool
    {
        if ($user->id === $team->user_id) {
            return true;
        }

        return false;
    }

    public function updateName(User $user, Team $team): bool
    {
        if ($user->id === $team->user_id) {
            return true;
        }

        return false;
    }

    public function show(?User $user, Team $team): bool
    {
        if (!$user) {
            return false;
        }

        if ($team->user_id === $user->id) {
            return true;
        }

        $teamMembersIds = $team->users()->pluck('users.id');

        if ($teamMembersIds->contains($user->id)) {
            return true;
        }

        return false;
    }
}
