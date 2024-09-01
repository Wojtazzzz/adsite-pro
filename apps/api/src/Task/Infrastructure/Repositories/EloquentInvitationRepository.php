<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use Modules\Task\Domain\Repositories\InvitationRepository;

class EloquentInvitationRepository implements InvitationRepository
{
    public function create(int $teamId, int $userId): void
    {
        Invitation::query()->create([
            'status' => InvitationStatus::PENDING->value,
            'user_id' => $userId,
            'team_id' => $teamId,
        ]);
    }
}
