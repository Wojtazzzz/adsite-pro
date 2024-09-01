<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use App\Bus\Command;
use App\Models\Team;
use App\Models\User;

class DeleteTeamMemberCommand extends Command
{
    public function __construct(
        public readonly Team $team,
        public readonly User $user,
    )
    {
    }
}
