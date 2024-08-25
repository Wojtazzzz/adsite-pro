<?php

declare(strict_types=1);

namespace Modules\Task\Queries;

use App\Bus\Query;

class GetUserTasksQuery extends Query
{
    public function __construct(
        public readonly int $user_id
    )
    {
    }
}
