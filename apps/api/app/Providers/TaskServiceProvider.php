<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use Illuminate\Support\ServiceProvider;
use Modules\Task\Application\Commands\Category\CreateCategoryCommand;
use Modules\Task\Application\Commands\Category\CreateCategoryCommandHandler;
use Modules\Task\Application\Commands\Invitation\CreateInvitationCommand;
use Modules\Task\Application\Commands\Invitation\CreateInvitationCommandHandler;
use Modules\Task\Application\Commands\Invitation\UpdateInvitationCommand;
use Modules\Task\Application\Commands\Invitation\UpdateInvitationCommandHandler;
use Modules\Task\Application\Commands\Task\CreateTaskCommand;
use Modules\Task\Application\Commands\Task\CreateTaskCommandHandler;
use Modules\Task\Application\Commands\Task\UpdateTaskStatusCommand;
use Modules\Task\Application\Commands\Task\UpdateTaskStatusCommandHandler;
use Modules\Task\Application\Commands\Team\CreateTeamCommand;
use Modules\Task\Application\Commands\Team\CreateTeamCommandHandler;
use Modules\Task\Application\Commands\Team\DeleteTeamCommand;
use Modules\Task\Application\Commands\Team\DeleteTeamCommandHandler;
use Modules\Task\Application\Commands\Team\DeleteTeamMemberCommand;
use Modules\Task\Application\Commands\Team\DeleteTeamMemberCommandHandler;
use Modules\Task\Application\Commands\Team\RenameTeamCommand;
use Modules\Task\Application\Commands\Team\RenameTeamCommandHandler;
use Modules\Task\Application\Queries\GetTeamMembersDetailsQuery;
use Modules\Task\Application\Queries\GetTeamMembersDetailsQueryHandler;
use Modules\Task\Application\Queries\GetTeamMembersQuery;
use Modules\Task\Application\Queries\GetTeamMembersQueryHandler;
use Modules\Task\Application\Queries\GetUserInvitationsQuery;
use Modules\Task\Application\Queries\GetUserInvitationsQueryHandler;
use Modules\Task\Application\Queries\GetUserTasksQuery;
use Modules\Task\Application\Queries\GetUserTasksQueryHandler;
use Modules\Task\Application\Queries\GetUserTeamsQuery;
use Modules\Task\Application\Queries\GetUserTeamsQueryHandler;
use Modules\Task\Domain\Repositories\CategoryRepository;
use Modules\Task\Domain\Repositories\InvitationRepository;
use Modules\Task\Domain\Repositories\TaskRepository;
use Modules\Task\Domain\Repositories\TeamRepository;
use Modules\Task\Domain\Repositories\UserRepository;
use Modules\Task\Infrastructure\Repositories\EloquentCategoryRepository;
use Modules\Task\Infrastructure\Repositories\EloquentInvitationRepository;
use Modules\Task\Infrastructure\Repositories\EloquentTaskRepository;
use Modules\Task\Infrastructure\Repositories\EloquentTeamRepository;
use Modules\Task\Infrastructure\Repositories\EloquentUserRepository;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TeamRepository::class, EloquentTeamRepository::class);
        $this->app->bind(TaskRepository::class, EloquentTaskRepository::class);
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(InvitationRepository::class, EloquentInvitationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $queryBus = app(QueryBus::class);

        $queryBus->register([
            GetUserTasksQuery::class => GetUserTasksQueryHandler::class,
            GetUserTeamsQuery::class => GetUserTeamsQueryHandler::class,
            GetTeamMembersQuery::class => GetTeamMembersQueryHandler::class,
            GetTeamMembersDetailsQuery::class => GetTeamMembersDetailsQueryHandler::class,
            GetUserInvitationsQuery::class => GetUserInvitationsQueryHandler::class,
        ]);

        $commandBus = app(CommandBus::class);

        $commandBus->register([
            UpdateTaskStatusCommand::class => UpdateTaskStatusCommandHandler::class,
            CreateTeamCommand::class => CreateTeamCommandHandler::class,
            DeleteTeamCommand::class => DeleteTeamCommandHandler::class,
            RenameTeamCommand::class => RenameTeamCommandHandler::class,
            CreateCategoryCommand::class => CreateCategoryCommandHandler::class,
            CreateTaskCommand::class => CreateTaskCommandHandler::class,
            CreateInvitationCommand::class => CreateInvitationCommandHandler::class,
            DeleteTeamMemberCommand::class => DeleteTeamMemberCommandHandler::class,
            UpdateInvitationCommand::class => UpdateInvitationCommandHandler::class,
        ]);
    }
}
