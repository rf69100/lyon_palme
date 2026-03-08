<?php

namespace App\Providers;

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
        // Strip /lyonpalme prefix pour fonctionner en sous-chemin nginx
        $uri = $this->app['request']->server->get('REQUEST_URI', '/');
        $stripped = preg_replace('#^/lyonpalme#', '', $uri) ?: '/';
        $this->app['request']->server->set('REQUEST_URI', $stripped);
    }
}
