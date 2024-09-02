<?php

declare(strict_types=1);

namespace Modules\Task\Api\Dto;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetUserTeamTasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'categories' => $this->categories->map(function (Category $category) {
                return [
                    'id' => $category->id,
                    'team_id' => $category->team_id,
                    'name' => $category->name,
                    'tasks' => $category->tasks->map(function (Task $task) {
                        return [
                            'id' => $task->id,
                            'category_id' => $task->category_id,
                            'user_id' => $task->user_id,
                            'name' => $task->name,
                            'description' => $task->description,
                            'status' => $task->status,
                            'estimation' => $task->estimation,
                            'created_at' => $task->created_at,
                            'user' => [
                                'id' => $task->user->id,
                                'name' => $task->user->name,
                            ]
                        ];
                    })
                ];
            })
        ];
    }
}
