<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Team;

use App\Bus\Command;
use App\Models\Team;

class DeleteTeamCommand extends Command
{
    public function __construct(
        public readonly Team $team,
    )
    {
    }
}
