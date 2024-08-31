<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\UserRepository;

readonly class GetTeamMembersDetailsQueryHandler
{
    public function __construct(private UserRepository $user)
    {
    }

    public function handle(GetTeamMembersDetailsQuery $query): Collection
    {
        return $this->user->getTeamMembersDetails($query->teamId);
    }
}
