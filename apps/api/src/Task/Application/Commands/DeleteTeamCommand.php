<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use App\Bus\Command;
use App\Models\Team;

class DeleteTeamCommand extends Command
{
    public function __construct(
        public readonly int $userId,
        public readonly Team $team,
    )
    {
    }
}
