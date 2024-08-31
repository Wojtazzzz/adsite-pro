<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Exceptions;

use App\Exceptions\DomainException;
use Throwable;

class UserOverloadedException extends DomainException
{
    public function __construct(string $message = "This user is overloaded in the current month", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
