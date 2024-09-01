<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Models\Category;
use App\Models\Invitation;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Task\Application\Commands\CreateCategoryCommand;
use Modules\Task\Application\Commands\CreateCategoryCommandHandler;
use Modules\Task\Application\Commands\CreateInvitationCommand;
use Modules\Task\Application\Commands\CreateInvitationCommandHandler;
use Modules\Task\Application\Commands\CreateTaskCommand;
use Modules\Task\Application\Commands\CreateTaskCommandHandler;
use Modules\Task\Application\Commands\CreateTeamCommand;
use Modules\Task\Application\Commands\CreateTeamCommandHandler;
use Modules\Task\Application\Commands\DeleteTeamCommand;
use Modules\Task\Application\Commands\DeleteTeamCommandHandler;
use Modules\Task\Application\Commands\RenameTeamCommand;
use Modules\Task\Application\Commands\RenameTeamCommandHandler;
use Modules\Task\Application\Commands\UpdateTaskStatusCommand;
use Modules\Task\Application\Commands\UpdateTaskStatusCommandHandler;
use Modules\Task\Application\Policies\CategoryPolicy;
use Modules\Task\Application\Policies\TaskPolicy;
use Modules\Task\Application\Policies\TeamPolicy;
use Modules\Task\Application\Queries\GetTeamMembersDetailsQuery;
use Modules\Task\Application\Queries\GetTeamMembersDetailsQueryHandler;
use Modules\Task\Application\Queries\GetTeamMembersQuery;
use Modules\Task\Application\Queries\GetTeamMembersQueryHandler;
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
        ]);
    }
}
