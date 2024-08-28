<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

use App\Models\Team;
use Modules\Task\Domain\Entities\Team as TeamEntity;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Exceptions\ExceededOwnedTeamsLimit;
use Modules\Task\Domain\Exceptions\OwnedTeamNameAlreadyTaken;

readonly class UserOwnedTeamsAggregate
{

    public function __construct(private Collection $teams)
    {
    }

    /**
     * @throws ExceededOwnedTeamsLimit
     * @throws OwnedTeamNameAlreadyTaken
     */
    public function addTeam(string $teamName): TeamEntity
    {
        if ($this->teams->count() >= 3) {
            throw new ExceededOwnedTeamsLimit();
        }

        if ($this->teams->isNotEmpty() && !$this->teams->every(fn(Team $team) => $team->name !== $teamName)) {
            throw new OwnedTeamNameAlreadyTaken();
        }

        return new TeamEntity($teamName);
    }
}
