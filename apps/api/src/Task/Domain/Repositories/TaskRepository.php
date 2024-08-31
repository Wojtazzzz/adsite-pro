<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use Modules\Task\Domain\Entities\Task;

interface TaskRepository
{
    public function updateStatus(int $taskId, string $newStatus): void;

    public function create(Task $entity): void;
}
