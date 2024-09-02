<?php

declare(strict_types=1);

namespace Modules\Task\Api\Requests;

use App\Enums\InvitationStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Task\Application\Policies\InvitationPolicy;

class UpdateInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $policy = new InvitationPolicy();

        return $policy->update(
            user: $this->user(),
            invitation: $this->invitation,
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
                Rule::in([InvitationStatus::ACCEPTED->value, InvitationStatus::REJECTED->value])
            ]
        ];
    }
}
