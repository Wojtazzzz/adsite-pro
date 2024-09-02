<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Task\Api\Dto\UserInvitationsResource;
use Modules\Task\Api\Requests\StoreInvitationRequest;
use Modules\Task\Api\Requests\UpdateInvitationRequest;
use Modules\Task\Application\Commands\Invitation\CreateInvitationCommand;
use Modules\Task\Application\Commands\Invitation\UpdateInvitationCommand;
use Modules\Task\Application\Queries\GetUserInvitationsQuery;

class InvitationController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
    )
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = new GetUserInvitationsQuery(
            userId: $request->user()->id
        );

        $data = $this->queryBus->query($query);

        return UserInvitationsResource::collection($data);
    }

    public function store(StoreInvitationRequest $request, Team $team): JsonResponse
    {
        $command = CreateInvitationCommand::from([
            'team' => $team,
            ...$request->validated()
        ]);

        $this->commandBus->dispatch($command);

        return response()->json([], 201);
    }

    public function update(UpdateInvitationRequest $request, Invitation $invitation): JsonResponse
    {
        $command = UpdateInvitationCommand::from([
            'invitation' => $invitation,
            ...$request->validated()
        ]);

        $this->commandBus->dispatch($command);

        return response()->json();
    }
}
