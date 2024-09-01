<?php

declare(strict_types=1);

namespace Modules\Task\Application\Commands;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Modules\Task\Application\Exceptions\UnauthorizedException;
use Modules\Task\Domain\Entities\CategoriesAggregate;
use Modules\Task\Domain\Exceptions\ExceededTeamCategoriesLimit;
use Modules\Task\Domain\Exceptions\TeamCategoryNameAlreadyTaken;
use Modules\Task\Domain\Repositories\CategoryRepository;
use Modules\Task\Domain\Repositories\InvitationRepository;
use Modules\Task\Domain\Repositories\UserRepository;

readonly class CreateInvitationCommandHandler
{
    public function __construct(
        private InvitationRepository $invitation,
        private UserRepository $user,
    )
    {
    }

    public function handle(CreateInvitationCommand $command): void
    {
        $user = $this->user->getByEmail($command->email);

        $this->invitation->create(
            teamId: $command->team->id,
            userId: $user->id
        );
    }
}
