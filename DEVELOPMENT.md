# Guide de Développement - Lyon Palme

Guide de référence rapide pour les développeurs travaillant sur le projet Lyon Palme.

## Démarrage Rapide

```bash
# Installation complète
composer setup

# Développement (lance tout en parallèle)
composer dev
```

## Structure du Projet

```
lyon_palme/
├── app/
│   ├── Http/Controllers/        # Contrôleurs (DashboardController)
│   ├── Models/                   # Modèles Eloquent (27 tables)
│   ├── Services/                 # Services métier (5 services)
│   └── Providers/               # Service providers
├── database/
│   ├── migrations/              # Migrations (27 tables + vue)
│   ├── factories/               # Factories pour tests
│   └── seeders/                 # Seeders (données de test)
├── resources/
│   ├── views/
│   │   ├── layouts/            # Layouts (public, app, navbar, footer)
│   │   ├── pages/              # Pages publiques
│   │   ├── auth/               # Pages authentification
│   │   └── dashboard/          # Pages dashboard
│   └── css/                    # Tailwind CSS 4
├── routes/
│   └── web.php                 # Routes web
└── tests/
    ├── Feature/                # Tests fonctionnels
    └── Unit/                   # Tests unitaires
```

## Layouts Blade

### Layout Public (`layouts.public`)
Pour toutes les pages publiques (accueil, about, support, pages légales).

```blade
@extends('layouts.public')

@section('title', 'Ma Page')

@push('styles')
<style>
    /* Styles spécifiques */
</style>
@endpush

@section('content')
    <!-- Contenu -->
@endsection

@push('scripts')
<script>
    // Scripts spécifiques
</script>
@endpush
```

### Layout App (`layouts.app`)
Pour les pages authentifiées (dashboard, adhérent, secrétaire).

```blade
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Contenu -->
@endsection
```

### Composants Layouts
- `layouts.navbar` - Navigation publique
- `layouts.footer` - Footer avec liens légaux

## Services Principaux

### 1. InputSanitizationService
Protection contre XSS et injections.

```php
use App\Services\InputSanitizationService;

// Nettoyer un texte
$clean = InputSanitizationService::sanitizeText($input);

// Nettoyer un email
$email = InputSanitizationService::sanitizeEmail($input);

// Nettoyer un téléphone
$phone = InputSanitizationService::sanitizePhone($input);

// Nettoyer un nom de fichier
$file = InputSanitizationService::sanitizeFileName($input);

// Détecter des patterns d'injection
if (InputSanitizationService::hasInjectionPatterns($input)) {
    // Bloquer
}
```

### 2. PasswordPolicyService
Gestion de la politique CNIL des mots de passe.

```php
use App\Services\PasswordPolicyService;

// Vérifier l'expiration (90 jours)
if (PasswordPolicyService::isPasswordExpired($user)) {
    // Forcer changement
}

// Jours avant expiration
$days = PasswordPolicyService::getDaysUntilExpiration($user);

// Marquer comme changé
PasswordPolicyService::markPasswordAsChanged($user);
```

### 3. AuditService
Traçabilité complète des actions.

```php
use App\Services\AuditService;

// Log générique
AuditService::log('action', 'Resource', $id, $old, $new);

// Logs spécialisés
AuditService::logLogin($email, $ip, true);
AuditService::logCreate('Adherent', $id, $data);
AuditService::logUpdate('Adherent', $id, $old, $new);
AuditService::logDelete('Adherent', $id, $old);
AuditService::logPasswordChange($userId);
AuditService::logUnauthorizedAccess('Resource', $id);
```

## Modèles Eloquent

### Champs Chiffrés (RGPD)
27 champs sensibles sont automatiquement chiffrés avec AES-256.

```php
// Adherent: 10 champs chiffrés
'telephone', 'mobile', 'adresse', 'complement_adresse',
'ville', 'code_postal', 'pays',
'contact_urgence_nom', 'contact_urgence_telephone', 'contact_urgence_relation'

// RepresentantLegal: 7 champs chiffrés
'telephone', 'mobile', 'adresse', 'complement_adresse',
'ville', 'code_postal', 'pays'
```

Le trait `EncryptsAttributes` gère le chiffrement/déchiffrement transparent.

### Scopes Utiles

```php
// Adhérents
Adherent::actif()->get();
Adherent::archive()->get();
Adherent::mineur()->get();
Adherent::majeur()->get();

// Certificats médicaux
CertificatMedical::valide()->get();
CertificatMedical::expire()->get();
CertificatMedical::expireBientot()->get();
```

## Tests

### Exécuter les Tests

```bash
# Tous les tests (301 tests)
php artisan test

# Tests avec détails
php artisan test --testdox

# Test spécifique
php artisan test tests/Unit/Services/AuditServiceTest.php

# Filtrer par nom
php artisan test --filter=sanitizeText
```

### Couverture Actuelle

- ✅ InputSanitizationService (21 tests)
- ✅ PasswordPolicyService (11 tests)
- ✅ AuditService (14 tests)
- ✅ DashboardController (13 tests)
- ✅ Modèles (multiples tests)
- ✅ Actions Fortify (multiples tests)

### Écrire un Test

```php
// tests/Unit/MyTest.php
<?php

use App\Services\MyService;

test('description du test', function () {
    $result = MyService::doSomething('input');

    expect($result)->toBe('expected');
});
```

## Commandes Artisan Utiles

```bash
# Développement
php artisan serve                    # Serveur local
php artisan queue:listen             # Worker de queue
php artisan pail                     # Logs en temps réel

# Tests
php artisan test                     # Tests
php artisan test --coverage          # Avec couverture

# Base de données
php artisan migrate                  # Migrations
php artisan migrate:fresh --seed     # Reset + seed
php artisan db:seed                  # Seed uniquement

# Code
./vendor/bin/pint                    # Formatter PSR-12
php artisan ide-helper:generate      # Aide IDE

# Cache
php artisan config:clear             # Clear config
php artisan cache:clear              # Clear cache
php artisan view:clear               # Clear views
```

## Standards de Code

### PSR-12
Utiliser Pint pour formater automatiquement:

```bash
./vendor/bin/pint
```

### Conventions Blade

```blade
<!-- Bon -->
<div class="flex gap-4">
    <div>Item 1</div>
    <div>Item 2</div>
</div>

<!-- Éviter -->
<div class="flex">
    <div class="mr-4">Item 1</div>
    <div>Item 2</div>
</div>
```

### Couleurs du Projet

```css
/* Couleurs principales (logo Lyon Palme) */
--color-purple: #5B4B8A;  /* Violet */
--color-cyan: #5DD9D2;    /* Cyan */

/* Classes Tailwind */
.bg-gradient-to-r.from-purple-600.to-cyan-500
.text-purple-600
.text-cyan-500
```

## Base de Données

### Connexion

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lyonpalme
```

### Tables Principales (27 total)

- `utilisateurs` - Authentification
- `adherents` - Membres (données chiffrées)
- `adhesions` - Adhésions avec solde calculé
- `certificats_medicaux` - Certificats avec alertes
- `certifications` - Qualifications FFESSM
- `audit_logs` - Traçabilité complète
- `consentements` - RGPD

### Vue SQL

```sql
-- Vue du statut des adhésions
SELECT * FROM v_statut_adhesions;
```

## Sécurité

### Checklist Avant Commit

- [ ] Pas de `env()` en dehors de `/config`
- [ ] Validation des inputs
- [ ] Protection CSRF active
- [ ] Pas de données sensibles en logs
- [ ] Tests passent (`php artisan test`)
- [ ] Code formaté (`./vendor/bin/pint`)

### Headers de Sécurité

Configurés dans `bootstrap/app.php`:
- X-Frame-Options: DENY
- X-Content-Type-Options: nosniff
- X-XSS-Protection: 1; mode=block

## Dépendances

### Production
- Laravel 12.0
- Tailwind CSS 4.0
- Spatie Permissions
- Spatie Media Library
- Maatwebsite Excel

### Développement
- Pest PHP 4
- Laravel Telescope
- Laravel Pint
- Debugbar

## Déploiement

```bash
# Production
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

## Support

- **README.md** - Documentation complète
- **SECURITY.md** - Politique de sécurité
- **CHANGELOG.md** - Historique des versions
- **CLAUDE.md** - Guidelines Laravel Boost

---

**Dernière mise à jour:** Décembre 2024
