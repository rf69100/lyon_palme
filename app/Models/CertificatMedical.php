<?php

namespace App\Models;

use App\Traits\EncryptsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificatMedical extends Model
{
    use EncryptsAttributes, HasFactory;

    protected $table = 'certificats_medicaux';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_id',
        'document_id',
        'delivre_le',
        'expire_le',
        'types_pratique',
        'nom_medecin',
        'numero_ordre_medecin',
        'est_medecin_federal',
        'restrictions',
        'questionnaire_sante_fourni',
        'statut',
    ];

    /**
     * Attributs sensibles - DONNÉES DE SANTÉ (Article 9 RGPD)
     *
     * ⚠️ CRITIQUE : Les données de santé sont des données sensibles
     * qui nécessitent un niveau de protection maximal selon l'Article 9 du RGPD.
     *
     * TOUTES les informations relatives aux certificats médicaux doivent être chiffrées.
     */
    protected $encryptable = [
        'nom_medecin',
        'numero_ordre_medecin',
        'restrictions',
    ];

    protected $casts = [
        'delivre_le' => 'date',
        'expire_le' => 'date',
        'est_medecin_federal' => 'boolean',
        'questionnaire_sante_fourni' => 'boolean',
    ];

    /**
     * Relation avec l'adhérent
     */
    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }

    /**
     * Relation avec le document (fichier PDF scanné)
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Vérifie si le certificat est encore valide
     */
    public function estValide(): bool
    {
        return $this->expire_le && $this->expire_le->isFuture();
    }

    /**
     * Vérifie si le certificat expire bientôt (dans moins de 30 jours)
     */
    public function expireBientot(int $jours = 30): bool
    {
        if (! $this->expire_le) {
            return false;
        }

        return $this->expire_le->isFuture() && $this->expire_le->diffInDays(now()) <= $jours;
    }

    /**
     * Scope pour récupérer les certificats valides
     */
    public function scopeValide($query)
    {
        return $query->where('expire_le', '>', now());
    }

    /**
     * Scope pour récupérer les certificats expirés
     */
    public function scopeExpire($query)
    {
        return $query->where('expire_le', '<=', now());
    }
}
