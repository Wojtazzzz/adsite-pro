<?php

declare(strict_types=1);

namespace Modules\Task\Domain;

use Illuminate\Support\Collection;

interface TeamRepository
{
    public function getUserTeamsWithTasks(int $user_id): Collection;
}
