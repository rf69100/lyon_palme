<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogAuditTrail
{
    // Routes that should be logged (only important actions)
    private array $trackedRoutes = [
        'PUT' => [
            'utilisateurs/*',
            'adherents/*',
            'adhesions/*',
        ],
        'POST' => [
            'utilisateurs',
            'adherents',
            'adhesions',
        ],
        'DELETE' => [
            'utilisateurs/*',
            'adherents/*',
            'adhesions/*',
        ],
    ];

    // Routes to exclude from logging (authentication/Fortify routes)
    private array $excludedRoutes = [
        'login',
        'logout',
        'register',
        'password/reset',
        'password/confirm',
        'profile',
        'password',
        'two-factor*',
        'sanctum*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log authenticated requests for sensitive operations
        if (Auth::check() && $this->shouldLog($request)) {
            try {
                AuditLog::create([
                    'utilisateur_id' => Auth::id(),
                    'action' => $this->getAction($request),
                    'resource_type' => $this->getResourceType($request),
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'success' => $response->getStatusCode() < 400,
                    'error_message' => $response->getStatusCode() >= 400 ? "HTTP {$response->getStatusCode()}" : null,
                ]);
            } catch (\Exception $e) {
                // Silently fail - don't break the app if audit logging fails
                \Log::error('Audit logging failed', ['exception' => $e->getMessage()]);
            }
        }

        return $response;
    }

    private function shouldLog(Request $request): bool
    {
        $method = $request->method();
        $path = $request->path();

        // Skip excluded routes (Fortify/authentication routes)
        foreach ($this->excludedRoutes as $excludedRoute) {
            if ($this->matchRoute($path, $excludedRoute)) {
                return false;
            }
        }

        if (!isset($this->trackedRoutes[$method])) {
            return false;
        }

        foreach ($this->trackedRoutes[$method] as $route) {
            if ($this->matchRoute($path, $route)) {
                return true;
            }
        }

        return false;
    }

    private function matchRoute(string $path, string $pattern): bool
    {
        $pattern = str_replace('*', '.*', $pattern);
        return (bool) preg_match("~^{$pattern}$~", $path);
    }

    private function getAction(Request $request): string
    {
        return match ($request->method()) {
            'POST' => match (true) {
                str_contains($request->path(), 'login') => 'login',
                str_contains($request->path(), 'logout') => 'logout',
                str_contains($request->path(), 'register') => 'create',
                default => 'create'
            },
            'PUT' => 'update',
            'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'access'
        };
    }

    private function getResourceType(Request $request): string
    {
        return match (true) {
            str_contains($request->path(), 'utilisateurs') => 'Utilisateur',
            str_contains($request->path(), 'adherents') => 'Adherent',
            str_contains($request->path(), 'adhesions') => 'Adhesion',
            str_contains($request->path(), 'profile') => 'Utilisateur',
            str_contains($request->path(), 'password') => 'Utilisateur',
            default => 'Unknown'
        };
    }
}
