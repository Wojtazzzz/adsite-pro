<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;


interface TaskRepository
{
    public function updateStatus(int $task_id, string $newStatus): void;
}
