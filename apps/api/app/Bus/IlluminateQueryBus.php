<?php

declare(strict_types=1);

namespace App\Bus;

use Illuminate\Bus\Dispatcher;

class IlluminateQueryBus implements QueryBus
{
    public function __construct(
        protected Dispatcher $bus
    )
    {
    }

    public function query(Query $query): mixed
    {
        return $this->bus->dispatch($query);
    }

    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
