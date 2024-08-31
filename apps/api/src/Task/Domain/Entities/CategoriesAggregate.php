<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Entities;

use Modules\Task\Domain\Entities\Category as CategoryEntity;
use Illuminate\Support\Collection;
use Modules\Task\Domain\Exceptions\ExceededTeamCategoriesLimit;
use Modules\Task\Domain\Exceptions\TeamCategoryNameAlreadyTaken;

readonly class CategoriesAggregate
{
    private Collection $categories;

    public function __construct(Collection $categories)
    {
        $this->categories = collect($categories->map(fn($category) => new CategoryEntity(
            name: $category->name,
            id: $category?->id
        )));
    }

    /**
     * @throws ExceededTeamCategoriesLimit
     * @throws TeamCategoryNameAlreadyTaken
     */
    public function addCategory(string $categoryName): CategoryEntity
    {
        if ($this->categories->count() >= 3) {
            throw new ExceededTeamCategoriesLimit();
        }

        if ($this->categories->isNotEmpty() && !$this->categories->every(fn(CategoryEntity $category) => $category->name !== $categoryName)) {
            throw new TeamCategoryNameAlreadyTaken();
        }

        return new CategoryEntity(name: $categoryName);
    }
}
