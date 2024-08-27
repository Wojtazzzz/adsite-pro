<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use App\Bus\Query;

class GetUserTasksQuery extends Query
{
    public function __construct(
        public readonly int $user_id,
        public readonly int $team_id
    )
    {
    }
}
