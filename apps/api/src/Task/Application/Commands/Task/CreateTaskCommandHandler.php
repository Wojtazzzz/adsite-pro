<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Task;

use Modules\Task\Domain\Entities\Task;
use Modules\Task\Domain\Entities\UserTeamMonthTasksAggregate;
use Modules\Task\Domain\Exceptions\UserOverloadedException;
use Modules\Task\Domain\Repositories\TaskRepository;
use Modules\Task\Domain\Repositories\UserRepository;

readonly class CreateTaskCommandHandler
{
    public function __construct(
        private UserRepository $user,
        private TaskRepository $task
    )
    {
    }

    /**
     * @throws UserOverloadedException
     */
    public function handle(CreateTaskCommand $command): void
    {
        $userTeamMonthTasks = new UserTeamMonthTasksAggregate(
            tasks: $this->user->getTasksByTeamFromCurrentMonth($command->userId, $command->team->id)
        );

        $taskEntity = $userTeamMonthTasks->addTask(
            entity: new Task(
                id: null,
                name: $command->name,
                description: $command->description,
                userId: $command->userId,
                categoryId: $command->category->id,
                status: $command->status,
                estimation: $command->estimation,
            )
        );

        $this->task->create($taskEntity);
    }
}
