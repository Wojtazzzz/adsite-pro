<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\IlluminateQueryBus;
use App\Bus\QueryBus;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Modules\Task\Domain\TeamRepository;
use Modules\Task\Queries\GetUserTasksQuery;
use Modules\Task\Queries\GetUserTasksQueryHandler;
use Modules\Task\Repositories\EloquentTeamRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $singletons = [
            QueryBus::class => IlluminateQueryBus::class
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        $this->app->bind(TeamRepository::class, EloquentTeamRepository::class);
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
        ]);
    }
}
