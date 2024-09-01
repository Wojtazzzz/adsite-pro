<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Modules\Task\Api\Dto\TeamMembers;
use Modules\Task\Api\Dto\TeamMembersDetails;
use Modules\Task\Api\Requests\DestroyUserRequest;
use Modules\Task\Api\Requests\DetailsUserRequest;
use Modules\Task\Api\Requests\IndexUserRequest;
use Modules\Task\Application\Commands\DeleteTeamMemberCommand;
use Modules\Task\Application\Queries\GetTeamMembersDetailsQuery;
use Modules\Task\Application\Queries\GetTeamMembersQuery;

class UserController extends Controller
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
    )
    {
    }

    public function index(IndexUserRequest $request, Team $team): AnonymousResourceCollection
    {
        $query = new GetTeamMembersQuery($team->id);

        $data = $this->queryBus->query($query);

        return TeamMembers::collection($data);
    }

    public function details(DetailsUserRequest $request, Team $team): AnonymousResourceCollection
    {
        $query = new GetTeamMembersDetailsQuery($team->id);

        $data = $this->queryBus->query($query);

        return TeamMembersDetails::collection($data);
    }

    public function destroy(DestroyUserRequest $request, Team $team, User $user): Response
    {
        $command = new DeleteTeamMemberCommand($team, $user);

        $this->commandBus->dispatch($command);

        return response()->noContent();
    }
}
