<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Team;

use Modules\Task\Domain\Repositories\TeamRepository;

readonly class DeleteTeamCommandHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    public function handle(DeleteTeamCommand $command): void
    {
        $this->team->delete($command->team->id);
    }
}
