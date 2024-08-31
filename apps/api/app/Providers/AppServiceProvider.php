<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\CommandBus;
use App\Bus\IlluminateCommandBus;
use App\Bus\IlluminateQueryBus;
use App\Bus\QueryBus;
use App\Models\Category;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Task\Application\Commands\CreateCategoryCommand;
use Modules\Task\Application\Commands\CreateCategoryCommandHandler;
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
use Modules\Task\Application\Queries\GetUserTeamsQuery;
use Modules\Task\Application\Queries\GetUserTeamsQueryHandler;
use Modules\Task\Application\Queries\GetUserTasksQuery;
use Modules\Task\Application\Queries\GetUserTasksQueryHandler;
use Modules\Task\Domain\Repositories\CategoryRepository;
use Modules\Task\Domain\Repositories\TaskRepository;
use Modules\Task\Domain\Repositories\TeamRepository;
use Modules\Task\Infrastructure\Repositories\EloquentCategoryRepository;
use Modules\Task\Infrastructure\Repositories\EloquentTaskRepository;
use Modules\Task\Infrastructure\Repositories\EloquentTeamRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $singletons = [
            QueryBus::class => IlluminateQueryBus::class,
            CommandBus::class => IlluminateCommandBus::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        $this->app->bind(TeamRepository::class, EloquentTeamRepository::class);
        $this->app->bind(TaskRepository::class, EloquentTaskRepository::class);
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        $queryBus = app(QueryBus::class);

        $queryBus->register([
            GetUserTasksQuery::class => GetUserTasksQueryHandler::class,
            GetUserTeamsQuery::class => GetUserTeamsQueryHandler::class,
        ]);

        $commandBus = app(CommandBus::class);

        $commandBus->register([
            UpdateTaskStatusCommand::class => UpdateTaskStatusCommandHandler::class,
            CreateTeamCommand::class => CreateTeamCommandHandler::class,
            DeleteTeamCommand::class => DeleteTeamCommandHandler::class,
            RenameTeamCommand::class => RenameTeamCommandHandler::class,
            CreateCategoryCommand::class => CreateCategoryCommandHandler::class,
        ]);

        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Team::class, TeamPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
    }
}
