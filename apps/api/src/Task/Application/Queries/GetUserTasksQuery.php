<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use App\Bus\Query;
use App\Models\Team;

class GetUserTasksQuery extends Query
{
    public function __construct(
        public readonly int $userId,
        public readonly Team $team
    )
    {
    }
}
