<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SlugServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoryRouteService::class, function ($app) {
            // At this point the categories routes will be determined.
            // It happens only one time even if you call the service multiple times through the container.
            return new CategoryRouteService();
        });
    }
}
