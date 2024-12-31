<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //TODO Establecer una politica de Pulse
        // Gate::define('viewPulse', function (User $user) {
        //     return $user->isAdmin();
        // });
        Passport::tokensExpireIn(now()->addYears(10));
    }
}
