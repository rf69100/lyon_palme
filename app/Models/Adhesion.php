<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
