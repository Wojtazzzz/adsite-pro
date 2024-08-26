<?php

declare(strict_types=1);

namespace Modules\Task\Application\Exceptions;

use App\Exceptions\ApplicationException;
use Throwable;

class UnauthorizedException extends ApplicationException
{
    public function __construct(string $message = "Unauthorized", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
