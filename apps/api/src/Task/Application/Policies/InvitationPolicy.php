<?php

declare(strict_types=1);

namespace Modules\Task\Application\Policies;

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Team;

class InvitationPolicy
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

    public function update(?User $user, Invitation $invitation): bool
    {
        if (!$user) {
            return false;
        }

        if ($invitation->status !== InvitationStatus::PENDING->value) {
            return false;
        }

        if ($invitation->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
