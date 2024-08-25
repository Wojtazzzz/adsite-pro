<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class TeamQueryBuilder extends Builder
{
    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);
    }

    public function userRelated(int $user_id): self
    {
        return $this->whereHas('users', function (Builder $query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });
    }
}
