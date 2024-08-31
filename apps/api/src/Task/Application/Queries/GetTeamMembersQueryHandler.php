<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\UserRepository;

readonly class GetTeamMembersQueryHandler
{
    public function __construct(private UserRepository $user)
    {
    }

    public function handle(GetTeamMembersQuery $query): Collection
    {
        return $this->user->getTeamMembers($query->teamId);
    }
}
