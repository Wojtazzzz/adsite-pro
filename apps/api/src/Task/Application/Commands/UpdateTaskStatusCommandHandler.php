<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use Modules\Task\Domain\Repositories\TaskRepository;

readonly class UpdateTaskStatusCommandHandler
{
    public function __construct(private TaskRepository $task)
    {
    }

    public function handle(UpdateTaskStatusCommand $command): void
    {
        $this->task->updateStatus($command->task->id, $command->status);
    }
}
