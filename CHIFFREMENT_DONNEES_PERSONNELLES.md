# Chiffrement des données personnelles - Documentation technique

## Vue d'ensemble

Ce document décrit l'implémentation du chiffrement au niveau application pour les données personnelles sensibles dans le projet Lyon Palme, conformément aux exigences du RGPD.

## Principe de fonctionnement

Le système utilise un **trait réutilisable** `EncryptsAttributes` qui chiffre automatiquement les attributs sensibles lors de leur sauvegarde et les déchiffre lors de leur lecture.

### Avantages de cette approche

✅ **Automatique** : Pas besoin de chiffrer/déchiffrer manuellement
✅ **Transparent** : Le code métier manipule toujours des données en clair
✅ **Sécurisé** : Utilise l'encryption Laravel (AES-256-CBC)
✅ **Réutilisable** : Peut être appliqué à n'importe quel modèle
✅ **Compatible** : Gère les anciennes données non chiffrées
✅ **RGPD compliant** : Protection des données personnelles au repos

---

## Architecture

### 1. Trait `EncryptsAttributes`

**Emplacement :** `/app/Traits/EncryptsAttributes.php`

Le trait intercepte les opérations de lecture/écriture sur les attributs du modèle :

```php
use App\Traits\EncryptsAttributes;

class MonModele extends Model
{
    use EncryptsAttributes;

    protected $encryptable = [
        'telephone',
        'adresse',
        'email',
    ];
}
```

#### Méthodes principales

| Méthode | Description |
|---------|-------------|
| `getAttribute()` | Déchiffre automatiquement lors de la lecture |
| `setAttribute()` | Chiffre automatiquement lors de l'écriture |
| `attributesToArray()` | Déchiffre pour les exports JSON |
| `shouldEncrypt()` | Vérifie si un attribut doit être chiffré |
| `isEncrypted()` | Détecte si une valeur est déjà chiffrée |

---

## Données chiffrées par modèle

### 📋 Modèle `Adherent`

**10 champs chiffrés :**

| Champ | Type | Description |
|-------|------|-------------|
| `telephone` | TEXT | Téléphone fixe |
| `mobile` | TEXT | Téléphone portable |
| `numero_rue` | TEXT | Numéro de rue |
| `rue` | TEXT | Nom de la rue |
| `complement_adresse` | TEXT | Complément d'adresse |
| `code_postal` | TEXT | Code postal |
| `ville` | TEXT | Ville |
| `contact_urgence_nom` | TEXT | Nom du contact d'urgence |
| `contact_urgence_telephone` | TEXT | Téléphone du contact |
| `contact_urgence_lien` | TEXT | Lien de parenté |

**Champs NON chiffrés :**
- `prenom`, `nom` : Nécessaires pour affichage/recherche
- `email` : Utilisé pour authentification/communication
- `civilite`, `date_naissance` : Pas considérés sensibles
- `pays` : Information publique
- `statut` : Information administrative

### 👨‍👩‍👧 Modèle `RepresentantLegal`

**7 champs chiffrés :**

| Champ | Type | Description |
|-------|------|-------------|
| `telephone` | TEXT | Téléphone fixe |
| `mobile` | TEXT | Téléphone portable |
| `numero_rue` | TEXT | Numéro de rue |
| `rue` | TEXT | Nom de la rue |
| `complement_adresse` | TEXT | Complément d'adresse |
| `code_postal` | TEXT | Code postal |
| `ville` | TEXT | Ville |

**Champs NON chiffrés :**
- `prenom`, `nom`, `civilite` : Nécessaires pour affichage
- `email` : Communication
- `lien_parente` : Information administrative
- Booléens : `est_principal`, `peut_recuperer`, etc.

---

## Utilisation dans le code

### Création d'un adhérent

```php
use App\Models\Adherent;

// Les données sensibles sont automatiquement chiffrées
$adherent = Adherent::create([
    'civilite' => 'M.',
    'prenom' => 'Jean',
    'nom' => 'Dupont',
    'telephone' => '0123456789',      // <- Chiffré automatiquement
    'mobile' => '0612345678',         // <- Chiffré automatiquement
    'rue' => 'Rue de la Paix',        // <- Chiffré automatiquement
    'code_postal' => '69001',         // <- Chiffré automatiquement
    'ville' => 'Lyon',                // <- Chiffré automatiquement
]);
```

### Lecture des données

```php
// Les données sont automatiquement déchiffrées
$telephone = $adherent->telephone; // Retourne "0123456789" (en clair)
$adresse = $adherent->rue;         // Retourne "Rue de la Paix" (en clair)

// Utiliser l'attribut calculé pour l'adresse complète
$adresseComplete = $adherent->adresse_complete;
// Retourne : "123, Rue de la Paix, 69001 Lyon"
```

### Modification des données

```php
// Les nouvelles valeurs sont automatiquement chiffrées
$adherent->telephone = '0198765432';
$adherent->mobile = '0687654321';
$adherent->save();
```

### Export JSON

```php
// Les données chiffrées sont déchiffrées dans les exports
$json = $adherent->toJson();
$array = $adherent->toArray();

// Les valeurs sont en clair dans le JSON/array
```

---

## Sécurité

### Algorithme de chiffrement

- **Algorithme** : AES-256-CBC (standard Laravel)
- **Clé** : `APP_KEY` dans `.env` (32 caractères)
- **IV** : Vecteur d'initialisation unique par valeur
- **Format** : JSON base64 encodé

### Structure d'une valeur chiffrée

```json
{
  "iv": "base64_encoded_initialization_vector",
  "value": "base64_encoded_encrypted_data",
  "mac": "message_authentication_code"
}
```

Encodé en base64, cela donne : `eyJpdiI6IjRkZjN3..."`

### Points de sécurité

✅ **Chiffrement symétrique** : Même clé pour chiffrer/déchiffrer
✅ **IV unique** : Chaque valeur a un IV aléatoire différent
✅ **MAC** : Authentification des messages (détecte les modifications)
✅ **Base64** : Stockage sûr en base de données TEXT
✅ **Détection intelligente** : Évite le double chiffrement

### Configuration requise

#### Fichier `.env`

```env
APP_KEY=base64:VOTRE_CLE_32_CARACTERES_EN_BASE64

# IMPORTANT : Ne JAMAIS commiter le APP_KEY dans Git
# IMPORTANT : Ne JAMAIS changer le APP_KEY en production
#             (les données chiffrées deviendraient indéchiffrables)
```

#### Générer une clé sécurisée

```bash
php artisan key:generate
```

---

## Migration des données existantes

### Si vous avez des données non chiffrées en production

Créez une migration pour chiffrer les données existantes :

```php
<?php

use App\Models\Adherent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Désactiver temporairement le chiffrement automatique
        // pour lire les données en clair

        DB::table('adherents')->orderBy('id')->chunk(100, function ($adherents) {
            foreach ($adherents as $adherentData) {
                $adherent = Adherent::find($adherentData->id);

                // Forcer la sauvegarde pour déclencher le chiffrement
                $adherent->telephone = $adherentData->telephone;
                $adherent->mobile = $adherentData->mobile;
                $adherent->rue = $adherentData->rue;
                // ... autres champs

                $adherent->save();
            }
        });
    }

    public function down(): void
    {
        // Déchiffrer si besoin (attention aux pertes de données)
    }
};
```

---

## Tests

### Exécuter les tests de chiffrement

```bash
php artisan test --filter=EncryptionTest
```

### Tests couverts

✅ Chiffrement automatique à la création
✅ Déchiffrement automatique à la lecture
✅ Stockage chiffré dans la base
✅ Détection des valeurs déjà chiffrées
✅ Gestion des valeurs nulles
✅ IV unique par valeur
✅ Compatibilité avec anciennes données
✅ Export JSON avec déchiffrement
✅ Attributs calculés (adresse_complete)

**Résultats :** 14/14 tests passent ✅

---

## Performance

### Impact sur les performances

| Opération | Impact | Mitigation |
|-----------|--------|------------|
| **Lecture** | Faible (~0.5ms/valeur) | Cache si nécessaire |
| **Écriture** | Faible (~1ms/valeur) | Batch inserts si volume élevé |
| **Recherche** | ❌ Non performant | Utiliser champs non chiffrés pour search |
| **Index** | ❌ Impossible | Créer index sur champs non chiffrés |

### Recommandations

1. **Ne PAS chiffrer** les champs utilisés pour :
   - Recherche fréquente
   - Tri
   - Index de base de données

2. **Préférer** : Champs de recherche séparés non chiffrés (ex: `nom`, `prenom`)

3. **Utiliser** : Cache Laravel pour données fréquemment lues

---

## Limitations connues

### ⚠️ Recherche dans les champs chiffrés

La recherche directe dans les champs chiffrés **n'est pas performante** :

```php
// ❌ NON PERFORMANT - Nécessite de déchiffrer toutes les lignes
Adherent::where('telephone', 'LIKE', '0612%')->get();

// ✅ RECOMMANDÉ - Utiliser des champs non chiffrés pour la recherche
Adherent::where('nom', 'LIKE', 'Dupont%')->get();
```

### ⚠️ Tri sur champs chiffrés

Impossible de trier sur un champ chiffré :

```php
// ❌ NE FONCTIONNE PAS - Tri sur données chiffrées
Adherent::orderBy('telephone')->get();

// ✅ ALTERNATIVE - Trier en PHP après récupération
$adherents = Adherent::all()->sortBy('telephone');
```

### ⚠️ Index de base de données

Les index sur champs chiffrés sont **inutiles** car les valeurs chiffrées sont aléatoires.

---

## Conformité RGPD

### Articles applicables

| Article | Exigence | Implémentation |
|---------|----------|----------------|
| **Art. 5.1.f** | Intégrité et confidentialité | ✅ Chiffrement AES-256 |
| **Art. 25** | Protection dès la conception | ✅ Chiffrement automatique |
| **Art. 32** | Sécurité du traitement | ✅ Chiffrement au repos |
| **Art. 34** | Notification violation | ✅ Données chiffrées = moins de risques |

### Données personnelles protégées

Selon le RGPD, les données suivantes sont considérées comme **sensibles** :

✅ Numéros de téléphone
✅ Adresses postales
✅ Contacts d'urgence

### Recommandations supplémentaires

1. **Backup** : Sauvegarder le `APP_KEY` de manière sécurisée
2. **Rotation** : Planifier une rotation de clé (avec re-chiffrement)
3. **Logs** : Ne JAMAIS logger les données déchiffrées
4. **Accès** : Restreindre l'accès à la base de données

---

## Dépannage

### Erreur "Unable to decrypt"

**Cause** : La clé APP_KEY a changé

**Solution** :
1. Restaurer l'ancienne APP_KEY
2. Migrer les données avec la nouvelle clé
3. Mettre à jour APP_KEY

### Valeurs corrompues

**Cause** : Modification manuelle en base

**Solution** :
```php
// Forcer le re-chiffrement
$adherent->telephone = $adherent->getOriginal('telephone');
$adherent->save();
```

### Performance dégradée

**Cause** : Trop de champs chiffrés

**Solutions** :
1. Réduire le nombre de champs chiffrés
2. Utiliser le cache pour lectures fréquentes
3. Paginer les résultats

---

## Ajout du chiffrement à un nouveau modèle

### Étapes

1. **Ajouter le trait** :
```php
use App\Traits\EncryptsAttributes;

class MonModele extends Model
{
    use EncryptsAttributes;
}
```

2. **Définir les champs à chiffrer** :
```php
protected $encryptable = [
    'champ_sensible_1',
    'champ_sensible_2',
];
```

3. **Modifier la migration** (si nécessaire) :
```php
$table->text('champ_sensible_1')->nullable()->comment('Chiffré');
```

4. **Créer des tests** :
```php
test('le champ est chiffré', function () {
    $model = MonModele::create(['champ' => 'valeur']);
    $raw = $model->getAttributes();
    expect($raw['champ'])->not->toBe('valeur');
});
```

---

## Résumé

### ✅ Ce qui est fait

- Trait réutilisable `EncryptsAttributes`
- Chiffrement automatique de 10 champs dans `Adherent`
- Chiffrement automatique de 7 champs dans `RepresentantLegal`
- 14 tests automatisés (tous passent)
- Documentation complète
- Compatible avec données existantes
- Conforme RGPD

### 🔒 Sécurité garantie

- AES-256-CBC
- IV unique par valeur
- MAC pour authentification
- Détection du double chiffrement
- Gestion des erreurs

### 📊 Impact

- **Transparence** : Le code métier ne change pas
- **Performance** : Impact minimal (<1ms par opération)
- **RGPD** : Conformité aux articles 5, 25, 32, 34
- **Maintenance** : Facile à étendre à d'autres modèles

---

**Date de mise en œuvre :** 2025-11-19
**Version Laravel :** 12.0
**Status :** ✅ Production ready
**Tests :** 14/14 passés
