<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Invitation;

use App\Bus\Command;
use App\Models\Team;

class CreateInvitationCommand extends Command
{
    public function __construct(
        public readonly Team $team,
        public readonly string $email,
    )
    {
    }

    public static function from(array $payloads): self
    {
        return new self($payloads['team'], $payloads['email']);
    }
}
