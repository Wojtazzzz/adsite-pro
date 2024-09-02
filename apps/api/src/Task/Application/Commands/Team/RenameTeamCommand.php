<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Team;

use App\Bus\Command;
use App\Models\Team;

class RenameTeamCommand extends Command
{
    public function __construct(
        public readonly Team $team,
        public readonly string $newName,
        public readonly int $userId,
    )
    {
    }

    public static function from(array $payloads): self
    {
        return new self($payloads['team'], $payloads['name'], $payloads['userId']);
    }
}
