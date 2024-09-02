<?php

declare(strict_types=1);

namespace Modules\Task\Application\Queries;

use Illuminate\Support\Collection;
use Modules\Task\Domain\Repositories\InvitationRepository;

readonly class GetUserInvitationsQueryHandler
{
    public function __construct(private InvitationRepository $invitation)
    {
    }

    public function handle(GetUserInvitationsQuery $query): Collection
    {
        return $this->invitation->getPendings(
            userId: $query->userId,
        );
    }
}
