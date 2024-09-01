<?php

declare(strict_types=1);

namespace App\Enums;

enum InvitationStatus: string
{
    case PENDING = 'PENDING';
    case REJECTED = 'REJECTED';
    case ACCEPTED = 'ACCEPTED';
}
