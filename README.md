# Lyon Palme - Plateforme de Gestion Interne

> **Application privée et exclusive** développée pour la gestion interne du club Lyon Palme, club de palmage et de plongée affilié à la FFESSM (Fédération Française d'Études et de Sports Sous-Marins) - Comité régional AURA.

## ⚠️ Important

**Cette application est spécifiquement conçue pour le club Lyon Palme uniquement.** Elle n'est pas destinée à être utilisée par d'autres clubs ou organismes. Toutes les fonctionnalités, configurations et données sont adaptées aux besoins spécifiques de notre club.

## À propos

Lyon Palme est la plateforme de gestion interne du club Lyon Palme basé à Vénissieux. Développée dans le cadre d'un projet BTS SIO, l'application couvre le **backlog US1–US18** : sécurité/RGPD, gestion des adhérents par le secrétariat (adhésions, paiements, certificats médicaux) et espace self-service pour les nageurs.

**Piscine d'entraînement principale :** Centre Nautique de Vénissieux
**Affiliation :** FFESSM - Comité Régional AURA
**Type :** Club de palmage, nage avec palmes et plongée

## Périmètre livré (US1–US18)

> ⚠️ **Hors-scope.** Les modules planning / séances d'entraînement / sorties / compétitions / matériel **ne font pas partie du livrable**. Leurs tables et modèles existent dans le schéma mais ne sont pas exposés dans l'application.

### Sécurité & RGPD (US1–US3)
- Politique de mot de passe CNIL (12+ caractères, complexité, expiration 90 jours)
- Piste d'audit complète (`audit_logs`) sur chaque action sensible
- Chiffrement des champs sensibles au repos (AES-256) via le trait `EncryptsAttributes`
- Gestion des consentements RGPD (traçabilité IP / user-agent, révocation)

### Espace Secrétaire / Administration (US4–US11)
- Authentification (Fortify) et changement de mot de passe
- CRUD complet des adhérents : rôles, représentant légal pour les mineurs, consentements RGPD
- Upload / téléchargement des certificats médicaux (PDF)
- Archivage et restauration des adhérents (soft delete)
- Tableau de bord des certificats médicaux (US10) avec export Excel
- Cotisations & paiements (US11) : adhésions par saison, types d'adhésion, suivi des paiements (espèces, chèque, virement, carte, Hello Asso), solde calculé automatiquement, export Excel

### Espace Nageur / Adhérent (US12–US18)
- Connexion (Fortify) ; compte créé par le secrétariat (mot de passe initial = date de naissance `AAAAMMJJ`)
- Mot de passe oublié / réinitialisation (Fortify)
- Profil self-service (`/mon-profil`)
- Opt-in trombinoscope / annuaire et listings publics (`/trombinoscope`, `/annuaire`)

### Contrôle d'accès
- Modèle utilisateur personnalisé `Utilisateur` (authentification Fortify sur mesure)
- Rôles via Spatie Laravel Permission, portés par l'**adhérent** : `secretaire`, `president`, `tresorier` (= administrateurs) et `adherent`
- Routes protégées par les middlewares `auth`, `verified`, `audit.trail`

## Prérequis

- PHP >= 8.4
- Composer
- Node.js & NPM
- MariaDB (connexion `mariadb`, base `lyonpalme`)
- Extensions PHP requises :
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML

## Installation

### 1. Cloner le projet

```bash
git clone <url-du-repo>
cd lyon_palme
```

### 2. Installation automatique

La commande suivante va tout installer et configurer :

```bash
composer setup
```

Cette commande va :
- Installer les dépendances PHP (composer install)
- Créer le fichier .env à partir de .env.example
- Générer la clé d'application
- Exécuter les migrations de base de données
- Installer les dépendances NPM
- Compiler les assets

### 3. Configuration manuelle (alternative)

Si vous préférez installer manuellement :

```bash
# Installer les dépendances PHP
composer install

# Copier le fichier de configuration
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
# DB_DATABASE=lyonpalme
# DB_USERNAME=votre_utilisateur
# DB_PASSWORD=votre_mot_de_passe

# Exécuter les migrations
php artisan migrate

# Installer les dépendances JavaScript
npm install

# Compiler les assets
npm run build
```

### 4. Configuration de la base de données

Créez une base de données MySQL/MariaDB :

```sql
CREATE DATABASE lyonpalme CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Configurez vos variables d'environnement dans `.env` :

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lyonpalme
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 5. Données de test (optionnel)

Pour remplir la base de données avec des données de test :

```bash
php artisan migrate:fresh --seed
```

Cela génère un jeu de données connu (~100 adhérents, adhésions, paiements, certificats médicaux) ainsi que les comptes de test.

### Comptes de test

Mot de passe `password` pour tous (liste complète dans `COMPTES_TEST.md`) :

| Email | Rôle |
| --- | --- |
| `admin@lyonpalme.fr` | Administration |
| `president@lyonpalme.fr` | Président |
| `secretaire@lyonpalme.fr` | Secrétaire |
| `tresorier@lyonpalme.fr` | Trésorier |

## Utilisation

### Environnement de développement

Pour lancer tous les services de développement en parallèle :

```bash
composer dev
```

Cette commande lance simultanément :
- **Serveur Laravel** (port 8000)
- **Queue worker** (traitement des jobs en arrière-plan)
- **Logs en temps réel** (via Laravel Pail)
- **Vite dev server** (hot reload pour les assets)

L'application sera accessible à : [http://localhost:8000](http://localhost:8000)

### Commandes individuelles

Si vous préférez lancer les services individuellement :

```bash
# Serveur de développement Laravel
php artisan serve

# File d'attente
php artisan queue:listen

# Logs en temps réel
php artisan pail

# Compilation des assets (hot reload)
npm run dev

# Compilation des assets (production)
npm run build
```

### Autres commandes utiles

```bash
# Telescope (débogage)
php artisan telescope:install

# Générer l'aide IDE
php artisan ide-helper:generate

# Formater le code selon PSR-12
./vendor/bin/pint

# Exécuter les tests
composer test
# ou
php artisan test
```

## Structure de la base de données

### Tables du périmètre livré

- **utilisateurs** : Authentification (modèle `Utilisateur`, colonnes `mot_de_passe` / `jeton_souvenir`)
- **adherents** : Membres du club (données chiffrées + colonnes de hash de recherche)
- **adhesions** : Adhésions avec solde calculé automatiquement (colonne générée)
- **roles & adherent_roles** : Système de rôles (Spatie)
- **saisons** : Saisons sportives
- **types_adhesion & tarifs** : Types et tarification
- **paiements** : Historique des paiements
- **certificats_medicaux** : Certificats médicaux (PDF)
- **representants_legaux** : Tuteurs légaux des mineurs (données chiffrées)
- **documents** : Stockage polymorphique de fichiers
- **consentements** : Consentements RGPD
- **audit_logs** : Piste d'audit des actions sensibles

> Les tables `seances_entrainement`, `programmes_entrainement`, `sorties`, `competitions`, `inventaire_materiel`, `prets_materiel`, `certifications`… existent dans le schéma mais relèvent des **modules hors-scope**.

### Vues

- **v_statut_adhesions** : Vue du statut des adhésions

### Caractéristiques spéciales

- Colonnes générées/calculées (solde dans adhesions)
- Champs chiffrés pour données sensibles
- Stratégie d'indexation complète
- Contraintes de clés étrangères avec cascade/null on delete
- Suivi des timestamps (cree_le/modifie_le)

## Stack technologique

### Backend

- **Laravel 12** (dernière version)
- **PHP 8.4+**
- **MariaDB**

### Frontend

- **Vite 7.0.7** (build tool)
- **Tailwind CSS 4.0.0** (framework CSS)
- **Blade** (templating)
- **Axios 1.11.0** (requêtes HTTP)

### Packages principaux

#### Production
- **spatie/laravel-permission** : Gestion des rôles et permissions
- **spatie/laravel-medialibrary** : Gestion des médias avec images responsive
- **spatie/laravel-backup** : Système de sauvegarde automatisé
- **maatwebsite/excel** : Export/import Excel
- **laravel/scout** : Recherche full-text
- **soved/laravel-gdpr** : Outils de conformité RGPD
- **laravel-lang/lang** : Support multilingue

#### Développement
- **laravel/telescope** : Assistant de débogage
- **barryvdh/laravel-debugbar** : Barre de débogage
- **barryvdh/laravel-ide-helper** : Autocomplétion IDE
- **laravel/pail** : Visualisation des logs
- **laravel/pint** : Formatage du code (PSR-12)
- **pestphp/pest** : Framework de tests moderne
- **laravel/sail** : Environnement Docker

## Sécurité

### Chiffrement des données (RGPD)

**Données chiffrées par modèle :**

- **Adherent** (10 champs) : téléphone, mobile, adresse complète, contact d'urgence
- **RepresentantLegal** (7 champs) : téléphone, mobile, adresse complète
- **Algorithme** : AES-256-CBC avec clé APP_KEY
- **Trait réutilisable** : `EncryptsAttributes` - chiffrage automatique transparent

### Authentification et Mots de passe

- **Politique CNIL** : 12+ caractères, majuscules, minuscules, chiffres, symboles requis
- **Hashage** : BCRYPT avec 12+ rounds
- **Expiration** : Les mots de passe expirent après 90 jours
- **Service** : `PasswordPolicyService` pour la gestion de l'expiration
- **Protection brute force** : Rate limiting (5 tentatives/min par email/IP)

### Audit et Traçabilité

- **Table `audit_logs`** : Enregistre toutes les actions critiques
- **Traçage complet** : Utilisateur, action, IP, User-Agent, timestamp
- **Middleware** : `LogAuditTrail` - trace les requêtes HTTP sensibles
- **Non-répudiation** : Impossible de nier une action effectuée

### Protection contre les attaques web

- **SQL Injection** : Requêtes paramétrées (Eloquent ORM), validation des inputs
- **XSS** : Blade escaping automatique, sanitization des entrées
- **CSRF** : Token CSRF automatique, validation sur POST/PUT/DELETE
- **Session hijacking** : Headers de sécurité (X-Frame-Options, X-Content-Type-Options, etc.)
- **Session sécurisée** : HttpOnly cookies, Secure flag (prod), SameSite configuré

### Contrôle d'accès

- **Authentification Fortify** : Système personnalisé avec modèle Utilisateur
- **Rôles et permissions** : rôles portés par l'adhérent via Spatie Laravel Permission (`secretaire`/`president`/`tresorier` = admin, `adherent`)
- **Email verification** : Vérification obligatoire avant accès
- **Middleware d'authentification** : Routes protégées par `auth`, `verified`, `audit.trail`

### Gestion des données sensibles

- **Validation des inputs** : Service `InputSanitizationService` centralisant les règles
- **Pas de données en logs** : Exclusion des mots de passe, tokens, données chiffrées
- **Exports sécurisés** : Limitation API (10 exports/heure), données échappées
- **Conformité RGPD** : Support des consentements, droit à l'oubli

### Sauvegardes

- **Système Spatie Backup** : Automatisé, crypté
- **Exclusions** : vendor et node_modules exclus

## Localisation

- Interface en français (noms de tables/champs en français)
- Locale par défaut configurable
- Packages Laravel Lang pour traductions

## Sauvegarde

- Système Spatie Backup configuré
- Exclusion automatique de vendor et node_modules

## Déploiement (VPS)

L'application est déployée en production sous le **sous-chemin** `https://www.ryanfonseca.fr/lyonpalme`.

- Le middleware `ForceSubpathUrl` réécrit les URLs générées pour fonctionner derrière ce préfixe.
- Le déploiement s'effectue via le script `deploy-php.sh` du VPS :

```bash
sudo ./deploy-php.sh --project "Lyon Palme"
```

Le script enchaîne : `git pull --rebase`, `composer install --no-dev`, `php artisan migrate --force`, régénération des caches (`route:cache`, `config:cache`, `view:cache`), permissions `storage` / `bootstrap/cache` pour `www-data`, `storage:link`, puis reload nginx et test d'accessibilité HTTP.

## Tests

Le projet utilise Pest PHP pour les tests :

```bash
# Exécuter tous les tests
php artisan test

# Un seul fichier / nom de test
php artisan test --filter=AdherentControllerTest

# Ou via composer (vide le cache de config puis lance la suite)
composer test
```

> ⚠️ **Les tests tournent sur la vraie base MariaDB `lyonpalme`** (`RefreshDatabase` est désactivé). Ils s'appuient sur les données seedées et ne sont pas hermétiques : un `migrate:fresh --seed` restaure un état connu.

## Scripts Composer

```bash
composer setup    # Installation complète du projet
composer dev      # Lance tous les services de développement
composer test     # Exécute les tests
```

## Contribution

Ce projet est développé pour le club Lyon Palme. Pour toute contribution :

1. Fork le projet
2. Créez votre branche (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## Licence

MIT License

## Support

Pour toute question ou support, contactez l'équipe de développement.

---

**Développé avec Laravel 12 et Tailwind CSS 4** | **FFESSM - Comité Régional AURA**
