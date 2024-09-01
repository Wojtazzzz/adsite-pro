<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bus\CommandBus;
use App\Bus\IlluminateCommandBus;
use App\Bus\IlluminateQueryBus;
use App\Bus\QueryBus;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
//            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
//        });
    }
}
