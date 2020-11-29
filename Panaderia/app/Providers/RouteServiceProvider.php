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
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->configureRoutePatterns();

        $this->routes(function () {
            Route::prefix('api')
                ->name('api.')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(intval(config('app.api_rate_limit')));
        });
    }

    /**
     * Configure the route patterns for the application.
     *
     * @return void
     */
    protected function configureRoutePatterns()
    {
        Route::pattern('id', '[0-9]+');
        Route::pattern('country_id', '[0-9]+');
        Route::pattern('region_id', '[0-9]+');
        Route::pattern('province_id', '[0-9]+');
        Route::pattern('institution_id', '[0-9]+');
        Route::pattern('campus_id', '[0-9]+');
        Route::pattern('career_id', '[0-9]+');
    }
}
