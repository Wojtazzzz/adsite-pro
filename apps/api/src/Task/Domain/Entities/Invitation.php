<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

use App\Enums\InvitationStatus;
use Modules\Task\Domain\Exceptions\CannotRespondToAnsweredInvitation;
use Modules\Task\Domain\Exceptions\CannotUpdateInvitationToPending;

class Invitation
{
    public function __construct(
        public readonly ?int $id,
        private string $status,
    )
    {
    }

    /**
     * @throws CannotRespondToAnsweredInvitation
     * @throws CannotUpdateInvitationToPending
     */
    public function updateStatus(string $newStatus): void
    {
        if ($this->status !== InvitationStatus::PENDING->value) {
            throw new CannotRespondToAnsweredInvitation();
        }

        if ($newStatus === InvitationStatus::PENDING->value) {
            throw new CannotUpdateInvitationToPending();
        }

        $this->status = $newStatus;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

}
