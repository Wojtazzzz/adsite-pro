<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use Illuminate\Support\Facades\Gate;
use Modules\Task\Application\Exceptions\UnauthorizedException;
use Modules\Task\Domain\Repositories\TaskRepository;

readonly class UpdateTaskStatusCommandHandler
{
    public function __construct(private TaskRepository $task)
    {
    }

    /**
     * @throws UnauthorizedException
     */
    public function handle(UpdateTaskStatusCommand $command): void
    {
        if (!Gate::allows('update-status', $command->task)) {
            throw new UnauthorizedException();
        }

        $this->task->updateStatus($command->task->id, $command->newStatus);
    }
}
