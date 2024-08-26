<?php

declare(strict_types=1);

namespace Modules\Task\Api\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTeamTasksByStatus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tasks_groups = collect(['idle' => [], 'in_progress' => [], 'completed' => []]);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'categories' => $this->categories->map(function (object $category) use ($tasks_groups) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'team_id' => $category->team_id,
//                    'tasks' => $tasks_groups->merge($category->tasks->mapToGroups(function (object $task) {
//                        return [mb_strtolower($task->status) => $task];
//                    })),
                    'tasks' => $category->tasks
                ];
            })
        ];
    }
}
