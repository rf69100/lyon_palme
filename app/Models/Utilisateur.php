<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateurs';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'nom',
        'email',
        'email_verifie_le',
        'mot_de_passe',
        'doit_changer_mdp',
    ];

    protected $hidden = [
        'mot_de_passe',
        'jeton_souvenir',
    ];

    protected function casts(): array
    {
        return [
            'email_verifie_le' => 'datetime',
            'doit_changer_mdp' => 'boolean',
            'mot_de_passe' => 'hashed',
        ];
    }

    /**
     * Get the password attribute name for authentication.
     */
    public function getAuthPasswordName(): string
    {
        return 'mot_de_passe';
    }

    /**
     * Get the remember token column name.
     */
    public function getRememberTokenName(): ?string
    {
        return 'jeton_souvenir';
    }

    /**
     * Adhérent associé à ce compte utilisateur.
     */
    public function adherent(): HasOne
    {
        return $this->hasOne(Adherent::class, 'utilisateur_id');
    }

    /**
     * Détermine si l'utilisateur possède un rôle administratif (secrétaire, président, trésorier).
     */
    public function estAdministrateur(): bool
    {
        return (bool) $this->adherent?->estAdministrateur();
    }
}
