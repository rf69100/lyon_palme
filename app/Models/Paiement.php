<?php

namespace App\Models;

use App\Traits\EncryptsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use EncryptsAttributes, HasFactory;

    protected $table = 'paiements';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adhesion_id',
        'montant',
        'moyen_paiement',
        'reference_paiement',
        'nom_banque',
        'numero_cheque',
        'paye_le',
        'depose_le',
        'statut',
        'remarques',
    ];

    /**
     * Attributs sensibles qui doivent être chiffrés (données bancaires)
     */
    protected $encryptable = [
        'reference_paiement',
        'nom_banque',
        'numero_cheque',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'paye_le' => 'date',
        'depose_le' => 'date',
    ];

    /**
     * Modes de paiement valides
     */
    public const MODES_PAIEMENT = [
        'especes' => 'Espèces',
        'cheque' => 'Chèque',
        'virement' => 'Virement',
        'carte_bancaire' => 'Carte bancaire',
        'helloasso' => 'Hello Asso',
    ];

    /**
     * Relation avec l'adhésion
     */
    public function adhesion(): BelongsTo
    {
        return $this->belongsTo(Adhesion::class);
    }

    /**
     * Récupère le libellé du mode de paiement
     */
    public function getModePaiementLibelleAttribute(): string
    {
        return self::MODES_PAIEMENT[$this->moyen_paiement] ?? $this->moyen_paiement;
    }
}
