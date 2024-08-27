<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Modules\Task\Api\Dto\UserTeamTasksByStatus;
use Modules\Task\Application\Queries\GetUserTasksQuery;

class TeamController extends Controller
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function show(Request $request, Team $team): UserTeamTasksByStatus
    {
        $query = new GetUserTasksQuery($request->user()->id, $team->id);

        $data = $this->queryBus->query($query);

        return new UserTeamTasksByStatus($data);
    }
}
