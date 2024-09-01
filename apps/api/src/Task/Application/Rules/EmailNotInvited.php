<?php

declare(strict_types=1);

namespace Modules\Task\Application\Rules;

use App\Enums\InvitationStatus;
use App\Models\Team;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

readonly class EmailNotInvited implements ValidationRule
{
    public function __construct(private Team $team)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $teamMembersByEmail = $this->team
            ->invitations()
            ->with('user')
            ->whereIn('status', [InvitationStatus::PENDING, InvitationStatus::REJECTED])
            ->get()
            ->pluck('user.email')
            ->toArray();

        if (in_array($value, $teamMembersByEmail)) {
            $fail('User is already invited of this team.');
        }
    }
}
