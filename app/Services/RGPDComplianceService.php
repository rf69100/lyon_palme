<?php

namespace App\Services;

use App\Models\Adherent;
use App\Models\Utilisateur;
use Carbon\Carbon;

class RGPDComplianceService
{
    // Data retention period (2 years for swimming club members)
    private const DATA_RETENTION_DAYS = 730;

    /**
     * Check if user has given consent for data processing
     */
    public static function hasConsent(Utilisateur $user, string $type = 'general'): bool
    {
        return $user->consentements()
            ->where('type', $type)
            ->where('consenti', true)
            ->where(function ($query) {
                $query->whereNull('date_expiration')
                    ->orWhere('date_expiration', '>', Carbon::now());
            })
            ->exists();
    }

    /**
     * Record user consent
     */
    public static function recordConsent(Utilisateur $user, string $type, bool $consenti): void
    {
        $user->consentements()->updateOrCreate(
            ['type' => $type],
            [
                'consenti' => $consenti,
                'date_consentement' => Carbon::now(),
            ]
        );
    }

    /**
     * Check if data should be deleted based on retention policy
     */
    public static function shouldDeleteOldData(Adherent $adherent): bool
    {
        if ($adherent->archive_le === null) {
            return false; // Active members should not be deleted
        }

        $archiveDate = $adherent->archive_le;
        $expirationDate = $archiveDate->addDays(self::DATA_RETENTION_DAYS);

        return Carbon::now()->isAfter($expirationDate);
    }

    /**
     * Anonymize user data (right to be forgotten)
     */
    public static function anonymizeUser(Utilisateur $user): void
    {
        // Delete sensitive data, keep only legal requirements
        $user->update([
            'email' => 'anonymized_' . $user->id . '@example.com',
            'nom' => 'Anonymized',
            'email_verifie_le' => null,
            'modifie_le' => Carbon::now(),
        ]);

        AuditService::log(
            action: 'data_anonymized',
            resourceType: 'Utilisateur',
            resourceId: $user->id
        );
    }

    /**
     * Export user data (GDPR right to data portability)
     */
    public static function exportUserData(Utilisateur $user): array
    {
        return [
            'utilisateur' => $user->only([
                'id', 'nom', 'email', 'email_verifie_le', 'cree_le', 'modifie_le'
            ]),
            'consentements' => $user->consentements()->get()->toArray(),
            'audit_logs' => $user->auditLogs()->get()->toArray(),
        ];
    }

    /**
     * Export member data
     */
    public static function exportMemberData(Adherent $adherent): array
    {
        return [
            'adherent' => $adherent->only([
                'id', 'civilite', 'prenom', 'nom', 'date_naissance', 'email',
                'telephone', 'mobile', 'adresse_complete', 'statut', 'cree_le'
            ]),
            'representants_legaux' => $adherent->representantsLegaux()->get()->toArray(),
            'certificats_medicaux' => $adherent->certificatsMedicaux()->get()->toArray(),
            'adhesions' => $adherent->adhesions()->get()->toArray(),
        ];
    }

    /**
     * Get data processing information for transparency
     */
    public static function getDataProcessingInfo(): array
    {
        return [
            'purpose' => 'Management of swimming club members and activities',
            'retention_period' => self::DATA_RETENTION_DAYS . ' days',
            'data_categories' => [
                'Identity information (name, email)',
                'Medical data (certificates)',
                'Financial data (membership fees)',
                'Activity data (participation records)',
            ],
            'legal_basis' => 'Contractual necessity and legitimate interest',
            'recipients' => [
                'Club administrators',
                'Activity coordinators',
            ],
            'rights' => [
                'Right to access',
                'Right to rectification',
                'Right to erasure (right to be forgotten)',
                'Right to data portability',
                'Right to withdraw consent',
            ],
        ];
    }
}
