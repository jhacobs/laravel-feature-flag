<?php

namespace Jhacobs\FeatureFlag;

use Jhacobs\FeatureFlag\Http\Middleware\FeatureFlag;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class FeatureFlagServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/feature-flag.php' => config_path('feature-flag.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('feature-flag', FeatureFlag::class);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/feature-flag.php',
            'feature-flag'
        );
    }
}
