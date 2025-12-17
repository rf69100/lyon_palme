<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    // Constantes pour les rôles principaux
    const SECRETAIRE = 'secretaire';

    const PRESIDENT = 'president';

    const TRESORIER = 'tresorier';

    const ADHERENT = 'adherent';

    protected $fillable = [
        'nom',
        'nom_affichage',
        'description',
        'afficher_annuaire',
    ];

    protected $casts = [
        'afficher_annuaire' => 'boolean',
    ];

    /**
     * Relation avec les adhérents via adherent_roles
     */
    public function adherentRoles(): HasMany
    {
        return $this->hasMany(AdherentRole::class);
    }

    /**
     * Relation many-to-many avec les adhérents
     */
    public function adherents()
    {
        return $this->belongsToMany(Adherent::class, 'adherent_roles')
            ->withPivot('saison_id', 'attribue_le', 'revoque_le', 'est_actif')
            ->withTimestamps();
    }

    /**
     * Vérifie si c'est un rôle administratif
     */
    public function estAdministratif(): bool
    {
        return in_array($this->nom, [self::SECRETAIRE, self::PRESIDENT, self::TRESORIER]);
    }

    /**
     * Scope pour récupérer uniquement les rôles administratifs
     */
    public function scopeAdministratif($query)
    {
        return $query->whereIn('nom', [self::SECRETAIRE, self::PRESIDENT, self::TRESORIER]);
    }
}
