<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Exceptions;

use App\Exceptions\DomainException;
use Throwable;

class CannotUpdateInvitationToPending extends DomainException
{
    public function __construct(string $message = "Cannot update inv", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
