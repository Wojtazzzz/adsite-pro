<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: string
{
    case IDLE = 'IDLE';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';
}
