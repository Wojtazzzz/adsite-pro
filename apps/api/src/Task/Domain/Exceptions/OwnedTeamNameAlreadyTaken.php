<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Exceptions;

use App\Exceptions\DomainException;
use Throwable;

class OwnedTeamNameAlreadyTaken extends DomainException
{
    public function __construct(string $message = "Owned team name already taken", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
