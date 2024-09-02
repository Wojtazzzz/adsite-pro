<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Team;

use Modules\Task\Domain\Entities\UserOwnedTeamsAggregate;
use Modules\Task\Domain\Exceptions\TeamNameAlreadyTaken;
use Modules\Task\Domain\Repositories\TeamRepository;

readonly class RenameTeamCommandHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    /**
     * @throws TeamNameAlreadyTaken
     */
    public function handle(RenameTeamCommand $command): void
    {
        $userOwnedTeams = $this->team->getUserOwnedTeams(userId: $command->userId);

        $userOwnedTeamsAggregate = new UserOwnedTeamsAggregate($userOwnedTeams);

        $teamEntity = $userOwnedTeamsAggregate->renameTeam(
            teamId: $command->team->id,
            newTeamName: $command->newName
        );

        $this->team->updateName(teamId: $command->team->id, newName: $teamEntity->name);
    }
}
