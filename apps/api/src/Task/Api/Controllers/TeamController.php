<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Task\Api\Dto\MemberTeams;
use Modules\Task\Api\Dto\UserTeamTasksByStatus;
use Modules\Task\Application\Queries\GetMemberTeamsQuery;
use Modules\Task\Application\Queries\GetUserTasksQuery;

class TeamController extends Controller
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = new GetMemberTeamsQuery($request->user()->id);

        $data = $this->queryBus->query($query);

        return MemberTeams::collection($data);
    }

    public function show(Request $request, Team $team)
    {
        $query = new GetUserTasksQuery($request->user()->id, $team->id);

        $data = $this->queryBus->query($query);

        return new UserTeamTasksByStatus($data);
    }
}
