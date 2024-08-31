<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Task\Api\Dto\TeamMembers;
use Modules\Task\Api\Dto\TeamMembersDetails;
use Modules\Task\Application\Queries\GetTeamMembersDetailsQuery;
use Modules\Task\Application\Queries\GetTeamMembersQuery;

class UserController extends Controller
{
    public function __construct(
        private readonly QueryBus $queryBus,
    )
    {
    }

    public function members(Team $team): AnonymousResourceCollection
    {
        $query = new GetTeamMembersQuery($team->id);

        $data = $this->queryBus->query($query);

        return TeamMembers::collection($data);
    }

    public function details(Team $team)
    {
        $query = new GetTeamMembersDetailsQuery($team->id);

        $data = $this->queryBus->query($query);

        return TeamMembersDetails::collection($data);
    }
}
