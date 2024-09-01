<?php

declare(strict_types=1);

namespace Modules\Task\Api\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Task\Application\Policies\TaskPolicy;

class UpdateTaskStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $policy = new TaskPolicy();

        return $policy->updateStatus(
            user: $this->user(),
            task: $this->task,
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
            'status' => [
                'required',
                'string',
                'in:IDLE,IN_PROGRESS,COMPLETED'
            ]
        ];
    }
}
