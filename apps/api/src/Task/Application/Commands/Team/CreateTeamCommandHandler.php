<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Team;

use Modules\Task\Domain\Entities\UserOwnedTeamsAggregate;
use Modules\Task\Domain\Exceptions\ExceededOwnedTeamsLimit;
use Modules\Task\Domain\Exceptions\TeamNameAlreadyTaken;
use Modules\Task\Domain\Repositories\TeamRepository;

readonly class CreateTeamCommandHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    /**
     * @throws ExceededOwnedTeamsLimit
     * @throws TeamNameAlreadyTaken
     */
    public function handle(CreateTeamCommand $command): void
    {
        $userOwnedTeams = $this->team->getUserOwnedTeams($command->user_id);

        $userOwnedTeamsAggregate = new UserOwnedTeamsAggregate($userOwnedTeams);

        $teamEntity = $userOwnedTeamsAggregate->addTeam($command->name);

        $this->team->createTeam($command->user_id, $teamEntity);
    }
}
