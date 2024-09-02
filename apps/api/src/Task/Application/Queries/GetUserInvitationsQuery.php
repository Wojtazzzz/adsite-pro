<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use App\Bus\Query;

class GetUserInvitationsQuery extends Query
{
    public function __construct(
        public readonly int $userId
    )
    {
    }
}
