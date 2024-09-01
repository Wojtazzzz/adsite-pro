<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use App\Bus\Command;
use App\Models\Task;

class UpdateTaskStatusCommand extends Command
{
    public function __construct(
        public readonly Task $task,
        public readonly string $status,
    )
    {
    }

    public static function from(array $payloads): self
    {
        return new self($payloads['task'], $payloads['status']);
    }
}
