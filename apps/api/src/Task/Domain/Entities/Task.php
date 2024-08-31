<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

use App\Enums\TaskStatus;

readonly class Task
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $description,
        public int $userId,
        public int $categoryId,
        public TaskStatus $status,
        public int $estimation,
    )
    {
    }
}
