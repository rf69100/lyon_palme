<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\AppServiceProvider::class,
        \App\Providers\FortifyServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Security Middleware - Applied to all web routes
        $middleware->web(append: [
            \App\Http\Middleware\SecureSessionHeaders::class,
        ]);
        $middleware->prepend(\App\Http\Middleware\ForceSubpathUrl::class);

        // Middleware aliases for specific routes
        $middleware->alias([
            'throttle.login' => \App\Http\Middleware\ThrottleLoginAttempts::class,
            'api.abuse' => \App\Http\Middleware\PreventApiAbuse::class,
            'auth.verify' => \App\Http\Middleware\EnforceAuthorization::class,
            'audit.trail' => \App\Http\Middleware\LogAuditTrail::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
