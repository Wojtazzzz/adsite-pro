<?php

declare(strict_types=1);

namespace Modules\Task\Application\Rules;

use App\Models\Team;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

readonly class TeamMember implements ValidationRule
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
        $members = [
            $this->team->user->id,
            ...$this->team->users->pluck('id'),
        ];

        if (!in_array($value, $members)) {
            $fail('User is not member of this team.');
        }
    }
}
