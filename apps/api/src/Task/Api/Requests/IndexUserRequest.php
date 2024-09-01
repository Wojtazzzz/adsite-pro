<?php

declare(strict_types=1);

namespace Modules\Task\Api\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Task\Application\Policies\TeamPolicy;
use Modules\Task\Application\Policies\UserPolicy;

class IndexUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $policy = new UserPolicy();

        return $policy->index(
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
        return [];
    }
}
