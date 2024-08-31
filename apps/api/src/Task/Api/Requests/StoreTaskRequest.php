<?php

declare(strict_types=1);

namespace Modules\Task\Api\Requests;

use App\Enums\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool)$this->user();
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
