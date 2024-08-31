<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class UserQueryBuilder extends Builder
{
    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);
    }

    public function teamRelated(int $teamId): self
    {
        return $this->where(function (Builder $query) use ($teamId) {
            return $query->whereHas('teams', fn(Builder $query) => $query->where('teams.id', $teamId))
                ->orWhereHas('team', fn(Builder $query) => $query->where('teams.id', $teamId));
        });
    }
}
