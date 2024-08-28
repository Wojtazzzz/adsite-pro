<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Task\Api\Dto\MemberTeams;
use Modules\Task\Api\Dto\UserTeamTasksByStatus;
use Modules\Task\Api\Requests\StoreTeamRequest;
use Modules\Task\Application\Commands\CreateTeamCommand;
use Modules\Task\Application\Queries\GetMemberTeamsQuery;
use Modules\Task\Application\Queries\GetUserTasksQuery;

class TeamController extends Controller
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = new GetMemberTeamsQuery($request->user()->id);

        $data = $this->queryBus->query($query);

        return MemberTeams::collection($data);
    }

    public function show(Request $request, Team $team): UserTeamTasksByStatus
    {
        $query = new GetUserTasksQuery($request->user()->id, $team->id);

        $data = $this->queryBus->query($query);

        return new UserTeamTasksByStatus($data);
    }

    public function store(StoreTeamRequest $request): JsonResponse
    {
        $command = new CreateTeamCommand($request->user()->id, ...$request->validated());

        $this->commandBus->dispatch($command);

        return response()->json([], 201);
    }
}
