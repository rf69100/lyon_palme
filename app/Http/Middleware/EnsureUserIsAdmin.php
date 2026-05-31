<?php

namespace App\Http\Middleware;

use App\Services\AuditService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restreint l'accès aux routes d'administration (gestion des adhérents,
 * certificats, cotisations, paiements) aux seuls comptes disposant d'un
 * rôle administratif : Secrétaire, Président ou Trésorier.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->estAdministrateur()) {
            AuditService::log(
                action: 'unauthorized_access_attempt',
                resourceType: 'Admin',
                success: false,
                errorMessage: 'Tentative d\'accès à une route administrateur sans rôle requis',
            );

            abort(403);
        }

        return $next($request);
    }
}
