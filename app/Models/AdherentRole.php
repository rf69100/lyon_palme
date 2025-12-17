<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdherentRole extends Model
{
    use HasFactory;

    protected $table = 'adherent_roles';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_id',
        'role_id',
        'saison_id',
        'attribue_le',
        'revoque_le',
        'est_actif',
    ];

    protected $casts = [
        'attribue_le' => 'date',
        'revoque_le' => 'date',
        'est_actif' => 'boolean',
    ];

    /**
     * Relation avec l'adhérent
     */
    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }

    /**
     * Relation avec le rôle
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation avec la saison
     */
    public function saison(): BelongsTo
    {
        return $this->belongsTo(Saison::class);
    }

    /**
     * Scope pour récupérer uniquement les rôles actifs
     */
    public function scopeActif($query)
    {
        return $query->where('est_actif', true)->whereNull('revoque_le');
    }

    /**
     * Vérifie si le rôle est actif
     */
    public function estActif(): bool
    {
        return $this->est_actif && $this->revoque_le === null;
    }

    /**
     * Révoquer un rôle
     */
    public function revoquer(): void
    {
        $this->update([
            'est_actif' => false,
            'revoque_le' => now(),
        ]);
    }
}
