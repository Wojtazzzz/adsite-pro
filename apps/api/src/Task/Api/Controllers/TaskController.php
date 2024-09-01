<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\CommandBus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Modules\Task\Api\Requests\StoreTaskRequest;
use Modules\Task\Api\Requests\UpdateTaskStatusRequest;
use Modules\Task\Application\Commands\CreateTaskCommand;
use Modules\Task\Application\Commands\UpdateTaskStatusCommand;

class TaskController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function store(StoreTaskRequest $request, Team $team, Category $category): JsonResponse
    {
        $command = CreateTaskCommand::from([
            'team' => $team,
            'category' => $category,
            ...$request->validated()
        ]);

        $this->commandBus->dispatch($command);

        return response()->json([], 201);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Team $team, Category $category, Task $task)
    {
        $command = UpdateTaskStatusCommand::from(['task' => $task, ...$request->validated()]);

        return $this->commandBus->dispatch($command);
    }
}
