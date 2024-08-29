<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use Illuminate\Support\Facades\Gate;
use Modules\Task\Application\Exceptions\UnauthorizedException;
use Modules\Task\Domain\Entities\UserOwnedTeamsAggregate;
use Modules\Task\Domain\Exceptions\TeamNameAlreadyTaken;
use Modules\Task\Domain\Repositories\TaskRepository;
use Modules\Task\Domain\Repositories\TeamRepository;

readonly class RenameTeamCommandHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    /**
     * @throws UnauthorizedException
     * @throws TeamNameAlreadyTaken
     */
    public function handle(RenameTeamCommand $command): void
    {
        if (!Gate::allows('update-name', $command->team)) {
            throw new UnauthorizedException();
        }

        $userOwnedTeams = $this->team->getUserOwnedTeams(userId: $command->userId);

        $userOwnedTeamsAggregate = new UserOwnedTeamsAggregate($userOwnedTeams);

        $teamEntity = $userOwnedTeamsAggregate->renameTeam(
            teamId: $command->team->id,
            newTeamName: $command->newName
        );

        $this->team->updateName(teamId: $command->team->id, newName: $teamEntity->name);
    }
}
