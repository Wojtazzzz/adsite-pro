<?php

declare(strict_types=1);

namespace Modules\Task\Api\Requests;

use App\Enums\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Task\Application\Policies\TaskPolicy;
use Modules\Task\Application\Rules\TeamMember;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $policy = new TaskPolicy();

        return $policy->store(
            user: $this->user(),
            team: $this->team,
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
                new TeamMember($this->team)
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:128',
            ],
            'description' => [
                'required',
                'string',
                'min:2',
                'max:1028',
            ],
            'estimation' => [
                'required',
                'numeric',
                'min:15'
            ],
            'status' => [
                'required',
                'string',
                Rule::enum(TaskStatus::class)
            ]
        ];
    }
}
