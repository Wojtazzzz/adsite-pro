<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

readonly class Team
{
    public function __construct(public string $name)
    {
    }
}
