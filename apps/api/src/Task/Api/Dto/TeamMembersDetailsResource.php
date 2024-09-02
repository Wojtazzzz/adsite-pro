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
            'tasks_count' => $this->tasks_count,
            'idle_tasks_count' => $this->idle_tasks_count,
            'in_progress_tasks_count' => $this->in_progress_tasks_count,
            'completed_tasks_count' => $this->completed_tasks_count,
            'total_estimation' => $this->total_estimation ?? 0,
        ];
    }
}
