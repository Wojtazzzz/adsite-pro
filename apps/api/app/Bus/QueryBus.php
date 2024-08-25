<?php

declare(strict_types=1);

namespace App\Bus;

interface QueryBus
{
    public function query(Query $query): mixed;

    public function register(array $map): void;
}
