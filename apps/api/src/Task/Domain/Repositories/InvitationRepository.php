<?php

declare(strict_types=1);

namespace Modules\Task\Domain\Repositories;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Entities\Category as TeamCategoryEntity;

interface InvitationRepository
{
    public function create(int $teamId, int $userId): void;
}
