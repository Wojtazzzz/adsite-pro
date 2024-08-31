<?php

declare(strict_types=1);

namespace Modules\Task\Infrastructure\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Modules\Task\Domain\Entities\Category as TeamCategoryEntity;
use Modules\Task\Domain\Repositories\CategoryRepository;

class EloquentCategoryRepository implements CategoryRepository
{
    public function getTeamCategories(int $teamId): Collection
    {
        return Category::query()
            ->where('team_id', $teamId)
            ->get();
    }

    public function create(int $teamId, TeamCategoryEntity $entity): void
    {
        Category::query()->create([
            'name' => $entity->name,
            'team_id' => $teamId,
        ]);
    }
}
