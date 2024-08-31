<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Entities\Category as TeamCategoryEntity;

interface CategoryRepository
{
    public function getTeamCategories(int $teamId): Collection;

    public function create(int $teamId, TeamCategoryEntity $entity): void;
}
