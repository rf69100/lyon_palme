# Migration du modèle User vers Utilisateur

## Contexte

Le projet Lyon Palme utilise un modèle d'authentification francisé `Utilisateur` au lieu du modèle `User` par défaut de Laravel. Cette migration nettoie le code en supprimant les fichiers inutilisés et en configurant correctement le système d'authentification.

## Modifications effectuées

### 1. Fichiers supprimés ❌

- **`app/Models/User.php`** - Modèle par défaut Laravel non utilisé
- **`database/factories/UserFactory.php`** - Factory non utilisée

### 2. Fichiers modifiés ✏️

#### `app/Models/Utilisateur.php`
- ✅ Hérite maintenant de `Illuminate\Foundation\Auth\User` (Authenticatable)
- ✅ Utilise les traits `HasFactory` et `Notifiable`
- ✅ Cast `'mot_de_passe' => 'hashed'` pour hashage automatique (Laravel 12+)
- ✅ Méthode `getAuthPasswordName()` retourne `'mot_de_passe'`
- ✅ Méthode `getRememberTokenName()` retourne `'jeton_souvenir'`
- ✅ Champs cachés : `mot_de_passe` et `jeton_souvenir`

#### `config/auth.php`
```php
// AVANT
'model' => env('AUTH_MODEL', App\Models\User::class),

// APRÈS
'model' => env('AUTH_MODEL', App\Models\Utilisateur::class),
```

#### `database/seeders/DatabaseSeeder.php`
- ✅ Suppression de l'import `use App\Models\User;` non utilisé

### 3. Tests créés ✅

#### `tests/Feature/UtilisateurPasswordHashTest.php`
Tests du hashage automatique des mots de passe :
- ✅ Hashage automatique lors de la création
- ✅ Hashage automatique lors de la modification
- ✅ Pas de double hashage si déjà hashé

**Résultats :** 3/3 tests passent ✅

### 4. Documentation créée 📚

#### `exemple_hashage_mot_de_passe.php`
Guide complet avec :
- 5 exemples d'utilisation pratiques
- Configuration bcrypt
- Intégration avec Auth facade
- Avantages du cast `hashed`
- Guide de migration

---

## Structure de la table `utilisateurs`

```sql
CREATE TABLE utilisateurs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(191) NOT NULL,
    email VARCHAR(191) UNIQUE NOT NULL,
    email_verifie_le TIMESTAMP NULL,
    mot_de_passe VARCHAR(255) NOT NULL COMMENT 'Hashé avec bcrypt',
    jeton_souvenir VARCHAR(100) NULL,
    doit_changer_mdp BOOLEAN DEFAULT TRUE,
    cree_le TIMESTAMP NULL,
    modifie_le TIMESTAMP NULL,
    INDEX idx_utilisateurs_email (email)
);
```

## Utilisation du modèle Utilisateur

### Création d'un utilisateur

```php
use App\Models\Utilisateur;

// Le mot de passe est automatiquement hashé !
$utilisateur = Utilisateur::create([
    'nom' => 'Jean Dupont',
    'email' => 'jean.dupont@lyonpalme.fr',
    'mot_de_passe' => 'MonMotDePasse123', // Texte en clair
]);
```

### Authentification

```php
use Illuminate\Support\Facades\Auth;

// Connexion
if (Auth::attempt(['email' => $email, 'mot_de_passe' => $password])) {
    // Authentification réussie
    $utilisateur = Auth::user(); // Instance de Utilisateur
}

// Vérifier si connecté
if (Auth::check()) {
    $utilisateur = Auth::user();
}

// Déconnexion
Auth::logout();
```

### Modification du mot de passe

```php
$utilisateur = Auth::user();
$utilisateur->mot_de_passe = 'NouveauMotDePasse'; // Hashé automatiquement
$utilisateur->doit_changer_mdp = false;
$utilisateur->save();
```

### Remember Me (Se souvenir de moi)

```php
// Connexion avec remember token
Auth::attempt($credentials, $remember = true);

// Le jeton_souvenir est automatiquement géré
```

---

## Configuration de sécurité

### Fichier `.env`

```env
# Nombre de rounds bcrypt (10-12 recommandé pour production)
BCRYPT_ROUNDS=12

# Optionnel : surcharger le modèle d'authentification
AUTH_MODEL=App\Models\Utilisateur
```

### Avantages du système actuel

✅ **Hashage automatique** : Plus besoin d'appeler `Hash::make()` manuellement
✅ **Francisation** : Tous les champs en français pour cohérence du projet
✅ **Sécurité** : bcrypt avec 12 rounds (configurable)
✅ **Détection intelligente** : Évite le double hashage automatiquement
✅ **Compatible Laravel 12** : Utilise les dernières fonctionnalités
✅ **Token "Se souvenir"** : Gestion automatique du `jeton_souvenir`
✅ **Flag changement MDP** : Champ `doit_changer_mdp` pour forcer la réinitialisation

---

## Vérification de la configuration

### Test de configuration
```bash
php artisan tinker
```

```php
// Vérifier le modèle d'authentification
config('auth.providers.users.model');
// Doit retourner: "App\Models\Utilisateur"

// Créer un utilisateur de test
$user = App\Models\Utilisateur::create([
    'nom' => 'Test',
    'email' => 'test@example.com',
    'mot_de_passe' => 'password'
]);

// Vérifier que le mot de passe est hashé
$user->mot_de_passe;
// Doit commencer par "$2y$12$..." (hash bcrypt)

// Nettoyer
$user->delete();
```

### Exécuter les tests
```bash
php artisan test --filter=UtilisateurPasswordHashTest
```

---

## Points d'attention

### ⚠️ Migrations existantes

Si vous avez déjà des données en production avec des mots de passe non hashés, vous devez créer une migration pour les hasher :

```php
// migration: 2025_xx_xx_hash_existing_passwords.php
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

Utilisateur::chunk(100, function ($utilisateurs) {
    foreach ($utilisateurs as $utilisateur) {
        // Vérifier si le mot de passe n'est pas déjà hashé
        if (!str_starts_with($utilisateur->mot_de_passe, '$2y$')) {
            $utilisateur->mot_de_passe = Hash::make($utilisateur->mot_de_passe);
            $utilisateur->save();
        }
    }
});
```

### ⚠️ Controllers à créer

Vous devrez créer les controllers d'authentification :
- `LoginController`
- `RegisterController`
- `PasswordResetController`

Ces controllers utiliseront automatiquement le modèle `Utilisateur` configuré dans `auth.php`.

### ⚠️ Seeders

Le `UtilisateurSeeder` crée actuellement les utilisateurs par défaut :
- admin@lyonpalme.fr
- president@lyonpalme.fr
- secretaire@lyonpalme.fr
- tresorier@lyonpalme.fr

Assurez-vous que les mots de passe sont bien hashés dans le seeder.

---

## Résultats des tests

```
✓ le mot de passe est automatiquement hashé lors de la création
✓ le mot de passe est automatiquement hashé lors de la modification
✓ le mot de passe hashé ne change pas si on réassigne le même hash

Tests: 3 passed (5 assertions)
```

---

## Prochaines étapes recommandées

1. ✅ **Créer les controllers d'authentification** (Login, Register, Password Reset)
2. ✅ **Créer les routes d'authentification** dans `routes/web.php`
3. ✅ **Créer les vues Blade** pour login/register
4. ✅ **Implémenter le middleware auth** pour protéger les routes
5. ✅ **Ajouter la gestion des rôles** avec Spatie Permission (déjà installé)
6. ✅ **Créer les seeders de rôles** pour les 11 rôles définis
7. ✅ **Tester l'authentification complète** end-to-end

---

**Date de migration :** 2025-11-19
**Laravel version :** 12.0
**PHP version :** 8.2+
**Status :** ✅ Migration complète et testée
