<?php

namespace App\Http\Middleware;

use App\Services\AuditService;
use Closure;
use Illuminate\Http\Request;

class EnforceAuthorization
{
    /**
     * This middleware ensures proper authorization checks are in place
     * to prevent IDOR (Insecure Direct Object Reference) attacks
     */
    public function handle(Request $request, Closure $next)
    {
        // Check for unauthorized access attempts on protected resources
        if ($this->isProtectedResourceRequest($request)) {
            if (! $this->isAuthorizedToAccessResource($request)) {
                AuditService::log(
                    action: 'unauthorized_access_attempt',
                    resourceType: $this->getResourceType($request),
                    resourceId: $this->getResourceId($request),
                    success: false,
                    errorMessage: 'User does not have permission to access this resource'
                );

                return response()->json([
                    'message' => 'You do not have permission to access this resource.',
                ], 403);
            }
        }

        return $next($request);
    }

    private function isProtectedResourceRequest(Request $request): bool
    {
        // Check if it's a specific resource request (has ID parameter)
        return preg_match('~/(utilisateurs|adherents|adhesions)/\d+~', $request->path()) > 0;
    }

    private function isAuthorizedToAccessResource(Request $request): bool
    {
        // This is a helper - actual authorization logic should be in controllers/policies
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        $resourceId = $this->getResourceId($request);

        // Admin or secretary can access any resource
        if ($user->hasRole(['admin', 'secretaire'])) {
            return true;
        }

        // Regular users can only access their own profile
        if (str_contains($request->path(), 'utilisateurs/'.$user->id)) {
            return true;
        }

        return false;
    }

    private function getResourceType(Request $request): string
    {
        return match (true) {
            str_contains($request->path(), 'utilisateurs') => 'Utilisateur',
            str_contains($request->path(), 'adherents') => 'Adherent',
            str_contains($request->path(), 'adhesions') => 'Adhesion',
            default => 'Unknown'
        };
    }

    private function getResourceId(Request $request): ?int
    {
        if (preg_match('~/(\d+)(?:/|$)~', $request->path(), $matches)) {
            return (int) $matches[1];
        }

        return null;
    }
}
