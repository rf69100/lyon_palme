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
        // Préfixe /lyonpalme : strip pour le routing, mais URL::forceRootUrl pour la génération
        \Illuminate\Support\Facades\URL::forceRootUrl('https://www.ryanfonseca.fr');
    
        $uri = $this->app['request']->server->get('REQUEST_URI', '/');
        $stripped = preg_replace('#^/lyonpalme#', '', $uri) ?: '/';
        $this->app['request']->server->set('REQUEST_URI', $stripped);
    
        // Préfixer toutes les routes générées avec /lyonpalme
        $this->app['request']->server->set('SCRIPT_NAME', '/lyonpalme/index.php');
    }
}
