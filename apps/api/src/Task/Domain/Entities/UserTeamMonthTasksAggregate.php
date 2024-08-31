<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

use App\Enums\TaskStatus;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Entities\Task as TaskEntity;
use Modules\Task\Domain\Exceptions\UserOverloadedException;

readonly class UserTeamMonthTasksAggregate
{
    private Collection $tasks;

    public function __construct(Collection $tasks)
    {
        $this->tasks = collect($tasks->map(fn($task) => new TaskEntity(
            id: $task?->id,
            name: $task->name,
            description: $task->description,
            userId: $task->user_id,
            categoryId: $task->category_id,
            status: TaskStatus::from($task->status),
            estimation: $task->estimation,
        )));
    }

    /**
     * @throws UserOverloadedException
     */
    public function addTask(TaskEntity $entity): TaskEntity
    {
        $totalMonthEstimation = $this->tasks->sum(fn(TaskEntity $task) => $task->estimation);

        // 9600 - this should be moved to separate settings module
        if (($totalMonthEstimation + $entity->estimation) > 9600) {
            throw new UserOverloadedException();
        }

        return $entity;
    }
}
