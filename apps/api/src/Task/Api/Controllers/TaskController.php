<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Task\Api\Dto\UserTeamTasksByStatus;
use Modules\Task\Api\Requests\UpdateTaskStatusRequest;
use Modules\Task\Application\Commands\UpdateTaskStatusCommand;
use Modules\Task\Application\Queries\GetUserTasksQuery;

class TaskController extends Controller
{
    public function __construct(private readonly QueryBus $queryBus, private readonly CommandBus $commandBus)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->queryBus->query(new GetUserTasksQuery($request->user()->id));

        return UserTeamTasksByStatus::collection($data);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $command = UpdateTaskStatusCommand::from(['task' => $task, ...$request->validated()]);

        return $this->commandBus->dispatch($command);
    }
}
