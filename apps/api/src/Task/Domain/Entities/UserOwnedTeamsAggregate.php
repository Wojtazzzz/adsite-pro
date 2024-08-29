<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

use Modules\Task\Domain\Entities\Team as TeamEntity;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Exceptions\ExceededOwnedTeamsLimit;
use Modules\Task\Domain\Exceptions\TeamNameAlreadyTaken;

readonly class UserOwnedTeamsAggregate
{
    private Collection $teams;

    public function __construct(Collection $teams)
    {
        $this->teams = collect($teams->map(fn($team) => new TeamEntity(
            name: $team->name,
            id: $team?->id
        )));
    }

    /**
     * @throws ExceededOwnedTeamsLimit
     * @throws TeamNameAlreadyTaken
     */
    public function addTeam(string $teamName): TeamEntity
    {
        if ($this->teams->count() >= 3) {
            throw new ExceededOwnedTeamsLimit();
        }

        if ($this->teams->isNotEmpty() && !$this->teams->every(fn(TeamEntity $team) => $team->name !== $teamName)) {
            throw new TeamNameAlreadyTaken();
        }

        return new TeamEntity(name: $teamName);
    }

    /**
     * @throws TeamNameAlreadyTaken
     */
    public function renameTeam(int $teamId, string $newTeamName): TeamEntity
    {
        $isNameAlreadyTaken = !$this->teams->every(function (TeamEntity $team) use ($teamId, $newTeamName) {
            if ($team->id === $teamId) {
                return true;
            }

            return $team->name !== $newTeamName;
        });


        if ($isNameAlreadyTaken) {
            throw new TeamNameAlreadyTaken();
        }

        return new TeamEntity($newTeamName);
    }
}
