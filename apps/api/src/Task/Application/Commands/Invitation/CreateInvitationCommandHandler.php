<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Invitation;

use Modules\Task\Domain\Repositories\InvitationRepository;
use Modules\Task\Domain\Repositories\UserRepository;

readonly class CreateInvitationCommandHandler
{
    public function __construct(
        private InvitationRepository $invitation,
        private UserRepository $user,
    )
    {
    }

    public function handle(CreateInvitationCommand $command): void
    {
        $user = $this->user->getByEmail($command->email);

        $this->invitation->create(
            teamId: $command->team->id,
            userId: $user->id
        );
    }
}
