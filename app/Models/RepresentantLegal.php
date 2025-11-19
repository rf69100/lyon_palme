<?php

namespace App\Models;

use App\Traits\EncryptsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepresentantLegal extends Model
{
    use HasFactory, EncryptsAttributes;

    protected $table = 'representants_legaux';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_mineur_id',
        'civilite',
        'prenom',
        'nom',
        'lien_parente',
        'email',
        'telephone',
        'mobile',
        'numero_rue',
        'rue',
        'complement_adresse',
        'code_postal',
        'ville',
        'pays',
        'est_principal',
        'peut_recuperer',
        'autorise_sortie',
        'autorise_transport',
    ];

    /**
     * Attributs sensibles qui doivent être chiffrés
     * Conformément au RGPD et aux bonnes pratiques de sécurité
     */
    protected $encryptable = [
        'telephone',
        'mobile',
        'numero_rue',
        'rue',
        'complement_adresse',
        'code_postal',
        'ville',
    ];

    protected $casts = [
        'est_principal' => 'boolean',
        'peut_recuperer' => 'boolean',
        'autorise_sortie' => 'boolean',
        'autorise_transport' => 'boolean',
    ];

    /**
     * Relation avec l'adhérent mineur
     */
    public function adherentMineur(): BelongsTo
    {
        return $this->belongsTo(Adherent::class, 'adherent_mineur_id');
    }

    /**
     * Retourne l'adresse complète (déchiffrée)
     */
    public function getAdresseCompleteAttribute(): string
    {
        $parts = array_filter([
            $this->numero_rue,
            $this->rue,
            $this->complement_adresse,
            $this->code_postal . ' ' . $this->ville,
            $this->pays !== 'France' ? $this->pays : null,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Retourne le nom complet
     */
    public function getNomCompletAttribute(): string
    {
        return trim($this->civilite . ' ' . $this->prenom . ' ' . $this->nom);
    }

    /**
     * Scope pour récupérer uniquement les représentants principaux
     */
    public function scopePrincipal($query)
    {
        return $query->where('est_principal', true);
    }

    /**
     * Vérifie si le représentant est le représentant principal
     */
    public function estPrincipal(): bool
    {
        return $this->est_principal === true;
    }

    /**
     * Vérifie si le représentant peut récupérer l'enfant
     */
    public function peutRecuperer(): bool
    {
        return $this->peut_recuperer === true;
    }

    /**
     * Vérifie si le représentant autorise les sorties
     */
    public function autoriseSortie(): bool
    {
        return $this->autorise_sortie === true;
    }

    /**
     * Vérifie si le représentant autorise le transport
     */
    public function autoriseTransport(): bool
    {
        return $this->autorise_transport === true;
    }
}
