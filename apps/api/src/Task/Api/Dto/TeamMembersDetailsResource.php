<?php

declare(strict_types=1);

namespace Modules\Task\Api\Dto;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamMembersDetailsResource extends JsonResource
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
            'tasksCount' => $this->tasks_count,
            'idleTasksCount' => $this->idle_tasks_count,
            'inProgressTasksCount' => $this->in_progress_tasks_count,
            'completedTasksCount' => $this->completed_tasks_count,
            'totalEstimation' => $this->total_estimation ?? 0,
        ];
    }
}
