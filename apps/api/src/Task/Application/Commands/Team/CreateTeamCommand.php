<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Team;

use App\Bus\Command;

class CreateTeamCommand extends Command
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $name,
    )
    {
    }
}
