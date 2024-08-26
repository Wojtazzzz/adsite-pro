<?php

declare(strict_types=1);

namespace Modules\Task\Api;

use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Task\Queries\GetUserTasksQuery;

class TaskController extends Controller
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->queryBus->query(new GetUserTasksQuery($request->user()->id));

        return UserTeamTasksByStatus::collection($data);
    }
}
