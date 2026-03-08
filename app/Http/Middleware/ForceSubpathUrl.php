<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceSubpathUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Strip /lyonpalme du REQUEST_URI pour le routing
        $uri = $request->server->get('REQUEST_URI', '/');
        $stripped = preg_replace('#^/lyonpalme#', '', $uri) ?: '/';
        $request->server->set('REQUEST_URI', $stripped);
        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->getContent()
        );

        // Forcer le préfixe sur toutes les URLs générées
        URL::forceRootUrl('https://www.ryanfonseca.fr/lyonpalme');

        return $next($request);
    }
}
