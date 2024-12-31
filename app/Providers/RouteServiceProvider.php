<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // Route::middleware('api')
            //     ->prefix('api')
            //     ->group(base_path('routes/api.php'));

            Route::prefix('api-manager')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api-manager.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api-kiosk')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api-kiosk.php'));

            Route::prefix('api-torniquet')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api-torniquet.php'));

            Route::prefix('api-registry')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api-registry.php'));

                Route::prefix('api-administrator')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api-administrator.php'));

                Route::prefix('api-notify')
                    ->middleware('api')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/api-notify.php'));
        });
    }
}
