<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Inertia\ResponseFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Request::macro('wantsModal', function () {
            return $this->header('X-Modal') ? true : false;
        });

        ResponseFactory::macro('modal', function (string $component, array $props, string $baseUrl) {
            $baseUrl = request()->header('referer') ?: $baseUrl;

            $request = Request::create($baseUrl);
            $route = Route::getRoutes()->match($request);

            $request->setRouteResolver(fn () => $route);

            Inertia::share('_modal', [
                'component' => $component,
                'props' => $props,
                'baseUrl' => $baseUrl,
            ]);

            app(SubstituteBindings::class)->handle($request, fn () => null);

            $response = $route->run();

            return $response;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
