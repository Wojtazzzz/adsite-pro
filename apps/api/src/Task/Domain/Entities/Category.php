<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

readonly class Category
{
    public function __construct(public string $name, public ?int $id = null)
    {
    }
}
