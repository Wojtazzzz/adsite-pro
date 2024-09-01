<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\CommandBus;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Modules\Task\Api\Requests\StoreInvitationRequest;
use Modules\Task\Application\Commands\CreateInvitationCommand;

class InvitationController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    )
    {
    }

    public function store(StoreInvitationRequest $request, Team $team): JsonResponse
    {
        $command = CreateInvitationCommand::from(['team' => $team, ...$request->validated()]);

        $this->commandBus->dispatch($command);

        return response()->json([], 201);
    }
}
