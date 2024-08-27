<?php

declare(strict_types=1);

namespace Modules\Task\Api\Controllers;

use App\Bus\CommandBus;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Modules\Task\Api\Requests\UpdateTaskStatusRequest;
use Modules\Task\Application\Commands\UpdateTaskStatusCommand;

class TaskController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $command = UpdateTaskStatusCommand::from(['task' => $task, ...$request->validated()]);

        return $this->commandBus->dispatch($command);
    }
}
