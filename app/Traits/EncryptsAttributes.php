<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

/**
 * Trait EncryptsAttributes
 *
 * Ce trait permet de chiffrer automatiquement certains attributs d'un modèle Eloquent
 * lors de leur sauvegarde et de les déchiffrer lors de leur lecture.
 *
 * Utilisation dans un modèle :
 *
 * use App\Traits\EncryptsAttributes;
 *
 * class MonModele extends Model
 * {
 *     use EncryptsAttributes;
 *
 *     protected $encryptable = ['telephone', 'adresse', 'email'];
 * }
 */
trait EncryptsAttributes
{
    /**
     * Déchiffre les attributs lors de la lecture depuis la base de données
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        // Si l'attribut doit être chiffré et a une valeur
        if ($this->shouldEncrypt($key) && !is_null($value)) {
            try {
                // Tenter de déchiffrer la valeur
                return Crypt::decryptString($value);
            } catch (DecryptException $e) {
                // Si le déchiffrement échoue, retourner la valeur brute
                // Cela permet de gérer les anciennes données non chiffrées
                return $value;
            }
        }

        return $value;
    }

    /**
     * Chiffre les attributs lors de la sauvegarde dans la base de données
     */
    public function setAttribute($key, $value)
    {
        // Si l'attribut doit être chiffré et a une valeur non nulle
        if ($this->shouldEncrypt($key) && !is_null($value)) {
            // Ne chiffrer que si la valeur n'est pas déjà chiffrée
            if (!$this->isEncrypted($value)) {
                $value = Crypt::encryptString($value);
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Retourne les attributs en tableau (pour toArray(), toJson(), etc.)
     * Les attributs chiffrés sont automatiquement déchiffrés
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getEncryptableAttributes() as $key) {
            if (isset($attributes[$key])) {
                try {
                    $attributes[$key] = Crypt::decryptString($attributes[$key]);
                } catch (DecryptException $e) {
                    // Garder la valeur brute si le déchiffrement échoue
                }
            }
        }

        return $attributes;
    }

    /**
     * Détermine si un attribut doit être chiffré
     */
    protected function shouldEncrypt(string $key): bool
    {
        return in_array($key, $this->getEncryptableAttributes());
    }

    /**
     * Retourne la liste des attributs à chiffrer
     */
    protected function getEncryptableAttributes(): array
    {
        return property_exists($this, 'encryptable') ? $this->encryptable : [];
    }

    /**
     * Vérifie si une valeur est déjà chiffrée
     *
     * Une valeur chiffrée par Laravel commence par "eyJpdiI6" (base64 de '{"iv":')
     * ou peut être détectée en tentant de la déchiffrer
     */
    protected function isEncrypted($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        // Les valeurs chiffrées par Laravel commencent généralement par "eyJpdiI6"
        if (str_starts_with($value, 'eyJpdiI6')) {
            return true;
        }

        // Tenter de déchiffrer pour vérifier
        try {
            Crypt::decryptString($value);
            return true;
        } catch (DecryptException $e) {
            return false;
        }
    }

    /**
     * Recherche dans les attributs chiffrés (pour les queries)
     *
     * Note : La recherche dans les champs chiffrés n'est pas performante
     * car elle nécessite de déchiffrer chaque enregistrement.
     * Pour des recherches fréquentes, utilisez des index ou des champs non chiffrés.
     */
    public function scopeWhereEncrypted($query, string $attribute, $value)
    {
        if (!$this->shouldEncrypt($attribute)) {
            return $query->where($attribute, $value);
        }

        // Chiffrer la valeur recherchée
        $encryptedValue = Crypt::encryptString($value);

        return $query->where($attribute, $encryptedValue);
    }

    /**
     * Méthode helper pour obtenir un attribut chiffré en clair
     */
    public function getDecrypted(string $attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * Méthode helper pour définir un attribut qui sera chiffré
     */
    public function setEncrypted(string $attribute, $value)
    {
        return $this->setAttribute($attribute, $value);
    }
}
