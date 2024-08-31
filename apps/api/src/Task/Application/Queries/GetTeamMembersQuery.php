<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use App\Bus\Query;

class GetTeamMembersQuery extends Query
{
    public function __construct(
        public readonly int $teamId
    )
    {
    }
}
