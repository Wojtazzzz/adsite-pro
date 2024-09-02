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
use Modules\Task\Api\Dto\MemberTeamsResource;
use Modules\Task\Api\Dto\GetUserTeamTasksResource;
use Modules\Task\Api\Requests\DestroyTeamRequest;
use Modules\Task\Api\Requests\RenameTeamRequest;
use Modules\Task\Api\Requests\ShowTeamRequest;
use Modules\Task\Api\Requests\StoreTeamRequest;
use Modules\Task\Application\Commands\CreateTeamCommand;
use Modules\Task\Application\Commands\DeleteTeamCommand;
use Modules\Task\Application\Commands\RenameTeamCommand;
use Modules\Task\Application\Queries\GetUserTeamsQuery;
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
        $query = new GetUserTeamsQuery($request->user()->id);

        $data = $this->queryBus->query($query);

        return MemberTeamsResource::collection($data);
    }

    public function show(ShowTeamRequest $request, Team $team): GetUserTeamTasksResource
    {
        $query = new GetUserTasksQuery($request->user()->id, $team);

        $data = $this->queryBus->query($query);

        return new GetUserTeamTasksResource($data);
    }

    public function store(StoreTeamRequest $request): JsonResponse
    {
        $command = new CreateTeamCommand($request->user()->id, ...$request->validated());

        $this->commandBus->dispatch($command);

        return response()->json([], 201);
    }

    public function destroy(DestroyTeamRequest $request, Team $team): JsonResponse
    {
        $command = new DeleteTeamCommand($team);

        $this->commandBus->dispatch($command);

        return response()->json([], 204);
    }

    public function rename(RenameTeamRequest $request, Team $team): JsonResponse
    {
        $command = RenameTeamCommand::from([
            'team' => $team,
            'userId' => $request->user()->id,
            ...$request->validated()
        ]);

        $this->commandBus->dispatch($command);

        return response()->json([]);
    }
}
