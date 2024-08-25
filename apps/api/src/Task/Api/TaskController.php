<?php

declare(strict_types=1);

namespace Modules\Task\Api;

use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Task\Queries\GetUserTasksQuery;

class TaskController extends Controller
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->queryBus->query(new GetUserTasksQuery($request->user()->id))
        );
    }
}
