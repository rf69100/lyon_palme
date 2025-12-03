<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureSessionHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Add security headers to prevent session hijacking and XSS
        $response->header('X-Content-Type-Options', 'nosniff');  // Prevent MIME sniffing
        $response->header('X-Frame-Options', 'SAMEORIGIN');      // Prevent clickjacking
        $response->header('X-XSS-Protection', '1; mode=block');  // Legacy XSS protection
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // HSTS - Force HTTPS (disabled on local, enable in production)
        if ($this->isProduction()) {
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }

    private function isProduction(): bool
    {
        return app()->environment('production');
    }
}
