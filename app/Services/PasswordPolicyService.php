<?php

namespace App\Services;

use App\Models\Utilisateur;
use Carbon\Carbon;

class PasswordPolicyService
{
    // CNIL recommandation: password expiration after 90 days
    private const PASSWORD_EXPIRATION_DAYS = 90;

    /**
     * Check if a password has expired
     */
    public static function isPasswordExpired(Utilisateur $user): bool
    {
        if (!$user->mot_de_passe_change_le) {
            // If password was never changed (old accounts), mark as expired
            return true;
        }

        $expirationDate = $user->mot_de_passe_change_le->addDays(self::PASSWORD_EXPIRATION_DAYS);
        return Carbon::now()->isAfter($expirationDate);
    }

    /**
     * Mark password as changed
     */
    public static function markPasswordAsChanged(Utilisateur $user): void
    {
        $user->update([
            'mot_de_passe_change_le' => Carbon::now(),
            'mot_de_passe_expire' => false,
        ]);

        AuditService::logPasswordChange($user->id);
    }

    /**
     * Mark all passwords as expired (for admin emergency policy)
     */
    public static function expireAllPasswords(): void
    {
        Utilisateur::query()->update([
            'mot_de_passe_expire' => true,
        ]);
    }

    /**
     * Get days until password expiration
     */
    public static function getDaysUntilExpiration(Utilisateur $user): ?int
    {
        if (!$user->mot_de_passe_change_le) {
            return 0; // Expired
        }

        $expirationDate = $user->mot_de_passe_change_le->addDays(self::PASSWORD_EXPIRATION_DAYS);
        $daysLeft = Carbon::now()->diffInDays($expirationDate, false);

        return max(0, $daysLeft);
    }

    /**
     * Check if password change is required
     */
    public static function isPasswordChangeRequired(Utilisateur $user): bool
    {
        return $user->mot_de_passe_expire || self::isPasswordExpired($user);
    }
}
