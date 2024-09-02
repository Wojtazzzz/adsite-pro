<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Team;


use Modules\Task\Domain\Repositories\UserRepository;

readonly class DeleteTeamMemberCommandHandler
{
    public function __construct(private UserRepository $user)
    {
    }

    public function handle(DeleteTeamMemberCommand $command): void
    {
        $this->user->deleteTeam($command->user->id, $command->team->id);
    }
}
