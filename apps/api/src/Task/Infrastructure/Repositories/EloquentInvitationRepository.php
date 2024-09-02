<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use Illuminate\Support\Collection;
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

    public function getPendings(int $userId): Collection
    {
        return Invitation::query()
            ->with('team:id,name')
            ->where('user_id', $userId)
            ->where('status', InvitationStatus::PENDING->value)
            ->get([
                'id',
                'team_id'
            ]);
    }

    public function updateStatus(int $invitationId, string $status): void
    {
        Invitation::query()
            ->findOrFail($invitationId)
            ->update(['status' => $status]);
    }
}
