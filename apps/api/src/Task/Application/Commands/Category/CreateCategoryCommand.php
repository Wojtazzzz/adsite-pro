<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Category;

use App\Bus\Command;
use App\Models\Team;

class CreateCategoryCommand extends Command
{
    public function __construct(
        public readonly Team $team,
        public readonly string $name,
    )
    {
    }

    public static function from(array $payloads): self
    {
        return new self($payloads['team'], $payloads['name']);
    }
}
