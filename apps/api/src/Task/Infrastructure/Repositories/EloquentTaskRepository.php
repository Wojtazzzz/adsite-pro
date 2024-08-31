<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\Task;
use Modules\Task\Domain\Entities\Task as TaskEntity;
use Modules\Task\Domain\Repositories\TaskRepository;

class EloquentTaskRepository implements TaskRepository
{
    public function updateStatus(int $taskId, string $newStatus): void
    {
        Task::query()->where('id', $taskId)->update(['status' => $newStatus]);
    }

    public function create(TaskEntity $entity): void
    {
        Task::query()->create([
            'user_id' => $entity->userId,
            'category_id' => $entity->categoryId,
            'name' => $entity->name,
            'description' => $entity->description,
            'estimation' => $entity->estimation,
            'status' => $entity->status,
        ]);
    }
}
