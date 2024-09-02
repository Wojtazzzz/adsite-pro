<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Invitation;

use App\Enums\InvitationStatus;
use Modules\Task\Domain\Entities\Invitation;
use Modules\Task\Domain\Exceptions\CannotRespondToAnsweredInvitation;
use Modules\Task\Domain\Exceptions\CannotUpdateInvitationToPending;
use Modules\Task\Domain\Repositories\InvitationRepository;
use Modules\Task\Domain\Repositories\TeamRepository;

readonly class UpdateInvitationCommandHandler
{
    public function __construct(
        private InvitationRepository $invitation,
        private TeamRepository $team,
    )
    {
    }

    /**
     * @throws CannotUpdateInvitationToPending
     * @throws CannotRespondToAnsweredInvitation
     */
    public function handle(UpdateInvitationCommand $command): void
    {
        $invitationEntity = new Invitation(
            id: $command->invitation->id,
            status: $command->invitation->status
        );

        $invitationEntity->updateStatus($command->status);

        $this->invitation->updateStatus(
            invitationId: $command->invitation->id,
            status: $invitationEntity->getStatus()
        );

        if ($invitationEntity->getStatus() === InvitationStatus::ACCEPTED->value) {
            $this->team->addMember(
                teamId: $command->invitation->team->id,
                userId: $command->invitation->user->id,
            );
        }
    }
}
