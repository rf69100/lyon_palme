<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adhesion extends Model
{
    use HasFactory;

    protected $table = 'adhesions';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_id',
        'saison_id',
        'type_adhesion_id',
        'tarif_id',
        'montant_attendu',
        'montant_paye',
        'date_inscription',
        'statut',
        'valide_le',
        'valide_par',
        'numero_recu',
        'remarques',
    ];

    protected $casts = [
        'montant_attendu' => 'decimal:2',
        'montant_paye' => 'decimal:2',
        'solde' => 'decimal:2',
        'date_inscription' => 'date',
        'valide_le' => 'datetime',
    ];

    /**
     * Relation avec l'adhérent
     */
    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }

    /**
     * Relation avec la saison
     */
    public function saison(): BelongsTo
    {
        return $this->belongsTo(Saison::class);
    }

    /**
     * Relation avec le type d'adhésion
     */
    public function typeAdhesion(): BelongsTo
    {
        return $this->belongsTo(TypeAdhesion::class);
    }

    /**
     * Relation avec les paiements
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Récupère le dernier paiement
     */
    public function dernierPaiement(): ?Paiement
    {
        return $this->paiements()->orderBy('paye_le', 'desc')->first();
    }

    /**
     * Calcule le statut du paiement
     */
    public function getStatutPaiementAttribute(): string
    {
        // Calculer le solde manuellement si la colonne générée n'est pas disponible
        $montantAttendu = (float) $this->montant_attendu;
        $montantPaye = (float) $this->montant_paye;
        $solde = $montantAttendu - $montantPaye;

        if ($solde <= 0) {
            return 'a_jour';
        }

        if ($montantPaye > 0) {
            return 'partiel';
        }

        return 'impaye';
    }
}
