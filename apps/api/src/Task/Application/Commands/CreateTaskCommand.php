<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use App\Bus\Command;
use App\Enums\TaskStatus;
use App\Models\Category;
use App\Models\Team;

class CreateTaskCommand extends Command
{
    public function __construct(
        public readonly Team $team,
        public readonly Category $category,
        public readonly string $name,
        public readonly string $description,
        public readonly TaskStatus $status,
        public readonly int $userId,
        public readonly int $estimation,
    )
    {
    }

    public static function from(array $payloads): self
    {
        return new self(
            team: $payloads['team'],
            category: $payloads['category'],
            name: $payloads['name'],
            description: $payloads['description'],
            status: TaskStatus::from($payloads['status']),
            userId: $payloads['user_id'],
            estimation: $payloads['estimation'],
        );
    }
}
