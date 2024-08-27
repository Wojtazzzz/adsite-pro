<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\CommandBus;
use App\Bus\IlluminateCommandBus;
use App\Bus\IlluminateQueryBus;
use App\Bus\QueryBus;
use App\Models\Task;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Task\Application\Commands\UpdateTaskStatusCommand;
use Modules\Task\Application\Commands\UpdateTaskStatusCommandHandler;
use Modules\Task\Application\Policies\TaskPolicy;
use Modules\Task\Application\Queries\GetMemberTeamsQuery;
use Modules\Task\Application\Queries\GetMemberTeamsQueryHandler;
use Modules\Task\Application\Queries\GetUserTasksQuery;
use Modules\Task\Application\Queries\GetUserTasksQueryHandler;
use Modules\Task\Domain\Repositories\TaskRepository;
use Modules\Task\Domain\Repositories\TeamRepository;
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
            GetMemberTeamsQuery::class => GetMemberTeamsQueryHandler::class,
        ]);

        $commandBus = app(CommandBus::class);

        $commandBus->register([
            UpdateTaskStatusCommand::class => UpdateTaskStatusCommandHandler::class,
        ]);

        Gate::policy(Task::class, TaskPolicy::class);
    }
}
