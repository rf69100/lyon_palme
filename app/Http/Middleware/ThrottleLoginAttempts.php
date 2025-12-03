<?php

namespace App\Http\Middleware;

use App\Services\AuditService;
use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLoginAttempts
{
    // 5 login attempts per minute per IP address
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOGIN_WINDOW_MINUTES = 1;

    public function __construct(private RateLimiter $limiter) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isLoginRequest($request)) {
            return $next($request);
        }

        $key = $this->getThrottleKey($request);
        $maxAttempts = self::MAX_LOGIN_ATTEMPTS;

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            AuditService::log(
                action: 'login_throttled',
                resourceType: 'Utilisateur',
                success: false,
                errorMessage: 'Too many login attempts'
            );

            return response()->json([
                'message' => 'Too many login attempts. Please try again in ' . $this->limiter->availableIn($key) . ' second(s).',
            ], 429);
        }

        // Record failed login attempt
        $this->limiter->hit($key, self::LOGIN_WINDOW_MINUTES * 60);

        $response = $next($request);

        // If login successful, reset the throttle counter
        if ($response->getStatusCode() < 300) {
            $this->limiter->reset($key);
        }

        return $response;
    }

    private function isLoginRequest(Request $request): bool
    {
        return $request->isMethod('post') && str_contains($request->path(), 'login');
    }

    private function getThrottleKey(Request $request): string
    {
        $email = $request->input('email');
        $ip = $request->ip();

        return "login_attempts:{$email}:{$ip}";
    }
}
