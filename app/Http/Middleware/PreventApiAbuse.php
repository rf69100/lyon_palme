<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class PreventApiAbuse
{
    // Rate limits per endpoint type
    private const EXPORT_LIMIT_PER_HOUR = 10;
    private const DOWNLOAD_LIMIT_PER_HOUR = 20;
    private const LIST_LIMIT_PER_MINUTE = 60;

    public function __construct(private RateLimiter $limiter) {}

    public function handle(Request $request, Closure $next)
    {
        if (!$this->shouldRateLimit($request)) {
            return $next($request);
        }

        $key = $this->getRateLimitKey($request);
        $maxAttempts = $this->getMaxAttempts($request);
        $decayMinutes = $this->getDecayMinutes($request);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'message' => 'Rate limit exceeded. Please try again later.',
            ], 429);
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        return $next($request);
    }

    private function shouldRateLimit(Request $request): bool
    {
        return str_contains($request->path(), 'export')
            || str_contains($request->path(), 'download')
            || (str_contains($request->path(), 'api') && $request->isMethod('GET'));
    }

    private function getRateLimitKey(Request $request): string
    {
        $userId = auth()->id();
        $endpoint = $request->path();

        return "api_rate_limit:{$userId}:{$endpoint}";
    }

    private function getMaxAttempts(Request $request): int
    {
        return match (true) {
            str_contains($request->path(), 'export') => self::EXPORT_LIMIT_PER_HOUR,
            str_contains($request->path(), 'download') => self::DOWNLOAD_LIMIT_PER_HOUR,
            default => self::LIST_LIMIT_PER_MINUTE,
        };
    }

    private function getDecayMinutes(Request $request): int
    {
        return match (true) {
            str_contains($request->path(), 'export') => 60,
            str_contains($request->path(), 'download') => 60,
            default => 1,
        };
    }
}
