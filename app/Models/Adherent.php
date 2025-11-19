<?php

namespace App\Models;

use App\Traits\EncryptsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adherent extends Model
{
    use HasFactory, EncryptsAttributes;

    protected $table = 'adherents';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'utilisateur_id',
        'civilite',
        'prenom',
        'nom',
        'date_naissance',
        'email',
        'telephone',
        'mobile',
        'numero_rue',
        'rue',
        'complement_adresse',
        'code_postal',
        'ville',
        'pays',
        'chemin_photo',
        'contact_urgence_nom',
        'contact_urgence_telephone',
        'contact_urgence_lien',
        'statut',
        'archive_le',
        'est_mineur',
        'nom_recherche',
        'prenom_recherche',
        'nom_complet_recherche',
    ];

    /**
     * Attributs sensibles qui doivent être chiffrés
     * Conformément au RGPD Article 4 et Article 9
     *
     * DONNÉES DIRECTEMENT IDENTIFIANTES (Art. 4) :
     * - nom, prenom, email
     *
     * DONNÉES INDIRECTEMENT IDENTIFIANTES (Art. 4) :
     * - date_naissance, telephone, mobile, adresse, contacts urgence
     */
    protected $encryptable = [
        // Directement identifiantes
        'nom',
        'prenom',
        'email',

        // Indirectement identifiantes
        'date_naissance',
        'telephone',
        'mobile',
        'numero_rue',
        'rue',
        'complement_adresse',
        'code_postal',
        'ville',
        'contact_urgence_nom',
        'contact_urgence_telephone',
        'contact_urgence_lien',
    ];

    protected $casts = [
        // NOTE: date_naissance est chiffré, donc ne peut pas être casté en 'date'
        // Le déchiffrement se fait avant, puis on peut parser manuellement si besoin
        'archive_le' => 'datetime',
        'est_mineur' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class);
    }

    /**
     * Relation avec les représentants légaux (pour les mineurs)
     */
    public function representantsLegaux(): HasMany
    {
        return $this->hasMany(RepresentantLegal::class);
    }

    /**
     * Relation avec les adhésions
     */
    public function adhesions(): HasMany
    {
        return $this->hasMany(Adhesion::class);
    }

    /**
     * Scope pour récupérer uniquement les adhérents actifs
     */
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour récupérer uniquement les adhérents archivés
     */
    public function scopeArchive($query)
    {
        return $query->where('statut', 'archive');
    }

    /**
     * Scope pour récupérer uniquement les mineurs
     */
    public function scopeMineur($query)
    {
        return $query->where('est_mineur', true);
    }

    /**
     * Scope pour récupérer uniquement les majeurs
     */
    public function scopeMajeur($query)
    {
        return $query->where('est_mineur', false);
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
     * Vérifie si l'adhérent est mineur
     */
    public function estMineur(): bool
    {
        return $this->est_mineur === true;
    }

    /**
     * Vérifie si l'adhérent est actif
     */
    public function estActif(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Archiver un adhérent
     */
    public function archiver(): void
    {
        $this->update([
            'statut' => 'archive',
            'archive_le' => now(),
        ]);
    }

    /**
     * Réactiver un adhérent archivé
     */
    public function reactiver(): void
    {
        $this->update([
            'statut' => 'actif',
            'archive_le' => null,
        ]);
    }

    /**
     * Recherche par nom (utilise le hash pour performance)
     *
     * @param string $nom Le nom à rechercher (exactement)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function rechercherParNom(string $nom)
    {
        $nomHash = hash('sha256', mb_strtolower($nom));
        return static::where('nom_recherche', $nomHash)->get();
    }

    /**
     * Recherche par prénom (utilise le hash pour performance)
     *
     * @param string $prenom Le prénom à rechercher (exactement)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function rechercherParPrenom(string $prenom)
    {
        $prenomHash = hash('sha256', mb_strtolower($prenom));
        return static::where('prenom_recherche', $prenomHash)->get();
    }

    /**
     * Recherche par nom complet (utilise le hash pour performance)
     *
     * @param string $nom Le nom
     * @param string $prenom Le prénom
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function rechercherParNomComplet(string $nom, string $prenom)
    {
        $nomCompletHash = hash('sha256', mb_strtolower($nom . ' ' . $prenom));
        return static::where('nom_complet_recherche', $nomCompletHash)->get();
    }
}
