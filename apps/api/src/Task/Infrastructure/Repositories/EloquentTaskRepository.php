<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\Task;
use Modules\Task\Domain\Repositories\TaskRepository;

class EloquentTaskRepository implements TaskRepository
{
    public function updateStatus(int $task_id, string $newStatus): void
    {
        Task::query()->where('id', $task_id)->update(['status' => $newStatus]);
    }
}
