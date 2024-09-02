<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands\Category;

use Modules\Task\Domain\Entities\CategoriesAggregate;
use Modules\Task\Domain\Exceptions\ExceededTeamCategoriesLimit;
use Modules\Task\Domain\Exceptions\TeamCategoryNameAlreadyTaken;
use Modules\Task\Domain\Repositories\CategoryRepository;

readonly class CreateCategoryCommandHandler
{
    public function __construct(private CategoryRepository $category)
    {
    }

    /**
     * @throws ExceededTeamCategoriesLimit
     * @throws TeamCategoryNameAlreadyTaken
     */
    public function handle(CreateCategoryCommand $command): void
    {
        $teamCategories = $this->category->getTeamCategories($command->team->id);

        $teamCategoriesAggregate = new CategoriesAggregate($teamCategories);

        $categoryEntity = $teamCategoriesAggregate->addCategory($command->name);

        $this->category->create($command->team->id, $categoryEntity);
    }
}
