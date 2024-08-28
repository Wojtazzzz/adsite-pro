<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Exceptions;

use App\Exceptions\DomainException;
use Throwable;

class ExceededOwnedTeamsLimit extends DomainException
{
    public function __construct(string $message = "Exceeded owned teams maximum limit", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
