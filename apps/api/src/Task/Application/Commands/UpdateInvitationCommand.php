<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use App\Bus\Command;
use App\Models\Invitation;

class UpdateInvitationCommand extends Command
{
    public function __construct(
        public readonly Invitation $invitation,
        public readonly string $status,
    )
    {
    }

    public static function from(array $payloads): self
    {
        return new self(
            invitation: $payloads['invitation'],
            status: $payloads['status']
        );
    }
}
