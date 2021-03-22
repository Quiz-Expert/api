<?php

declare(strict_types=1);

namespace Quiz\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->mapRoutes();
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for(
            "api",
            function (Request $request): Limit {
                return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
            }
        );
    }

    protected function mapRoutes(): void
    {
        $this->routes(
            function (Router $router): void {
                $router->middleware("api")
                    ->group(base_path("routes/api.php"));
            }
        );
    }
}
