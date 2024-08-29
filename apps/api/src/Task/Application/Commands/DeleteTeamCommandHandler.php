<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use Illuminate\Support\Facades\Gate;
use Modules\Task\Application\Exceptions\UnauthorizedException;
use Modules\Task\Domain\Repositories\TaskRepository;
use Modules\Task\Domain\Repositories\TeamRepository;

readonly class DeleteTeamCommandHandler
{
    public function __construct(private TeamRepository $team)
    {
    }

    /**
     * @throws UnauthorizedException
     */
    public function handle(DeleteTeamCommand $command): void
    {
        if (!Gate::allows('delete', $command->team)) {
            throw new UnauthorizedException();
        }

        $this->team->delete($command->team->id);
    }
}
