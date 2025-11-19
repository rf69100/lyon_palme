# Lyon Palme - Système de Gestion de Club de Natation

> Application Laravel de gestion complète pour le club de palmage de Lyon, affilié à la FFESSM (Fédération Française d'Études et de Sports Sous-Marins) - Comité régional AURA.

## À propos

Lyon Palme est une plateforme de gestion complète développée pour gérer l'ensemble des activités d'un club de natation et de palmage. L'application couvre tous les aspects de la gestion d'un club sportif : adhésions, entraînements, compétitions, matériel, finances et conformité RGPD.

**Piscine d'entraînement principale :** Centre Nautique de Vénissieux

## Fonctionnalités principales

### Gestion des adhérents
- Inscription des membres (adultes et mineurs)
- Gestion des représentants légaux pour les mineurs
- Chiffrement des données personnelles sensibles (téléphone, adresse)
- Photos de profil avec bibliothèque média
- Contacts d'urgence
- Suivi du statut des membres (actif/archivé)

### Gestion des adhésions et finances
- Adhésions basées sur les saisons
- Types d'adhésion multiples (Adulte, Junior, Étudiant, Enfant)
- Système de tarification dynamique
- Suivi des paiements (espèces, chèque, virement, carte, Hello Asso)
- Calcul automatique du solde (montant attendu - montant payé)
- Génération de numéros de reçus
- Suivi du statut des paiements

### Gestion médicale et certifications
- Gestion des certificats médicaux avec suivi d'expiration
- Support pour médecins fédéraux
- Suivi des questionnaires de santé
- Documentation des restrictions médicales
- Suivi des certifications (niveaux de plongée, qualifications natation)
- Système de versioning des documents

### Gestion des entraînements
- Planification des séances d'entraînement
- Création et gestion de programmes d'entraînement
- Affectation des entraîneurs aux séances
- Détails des bassins (25m par défaut)
- Limites de participants et niveaux requis
- Suivi des annulations

### Événements et activités
- Gestion des sorties/excursions
- Suivi des conditions météo et température de l'eau
- Instructions de sécurité
- Points de rendez-vous et localisation
- Affectation des organisateurs
- Inscription des participants

### Gestion des compétitions
- Compétitions régionales et nationales
- Intégration FFESSM
- Modalités/catégories de compétition
- Dates limites d'inscription
- Suivi des hébergements
- Limites de participants
- Résultats de compétition

### Gestion du matériel
- Système d'inventaire complet
- Types d'équipement (palmes, masques, tubas, combinaisons, etc.)
- Système de prêt/emprunt
- Suivi des retours et de l'état
- Suivi des tailles/marques
- Historique d'achat et prix

### Conformité RGPD
- Système de gestion des consentements
- Traçabilité IP et user agent
- Support de la révocation
- Contrôles de confidentialité (package soved/laravel-gdpr)

### Contrôle d'accès
- Système d'authentification utilisateur personnalisé
- Système basé sur 11 rôles prédéfinis :
  - Président
  - Vice-président
  - Secrétaire & Secrétaire adjoint
  - Trésorier
  - Coach & Entraîneur
  - Responsable planning
  - Responsable matériel
  - Responsable communication
  - Adhérent
- Paramètres de visibilité de l'annuaire par rôle
- Intégration Spatie Laravel Permission

## Prérequis

- PHP >= 8.2
- Composer
- Node.js & NPM
- MariaDB/MySQL
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
php artisan db:seed
```

Cela générera :
- 100 adhérents
- Séances d'entraînement
- Compétitions
- Sorties
- Et bien plus...

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

### Tables principales

- **utilisateurs** : Authentification et utilisateurs
- **adherents** : Membres du club (données chiffrées)
- **adhesions** : Adhésions avec solde calculé automatiquement
- **roles & adherent_roles** : Système de rôles
- **saisons** : Saisons sportives
- **types_adhesion & tarifs** : Types et tarification
- **paiements** : Historique des paiements
- **certificats_medicaux** : Certificats médicaux
- **certifications** : Qualifications plongée/natation
- **representants_legaux** : Tuteurs légaux des mineurs
- **seances_entrainement** : Séances d'entraînement
- **programmes_entrainement** : Programmes
- **sorties** : Sorties et excursions
- **competitions** : Compétitions régionales/nationales
- **inventaire_materiel** : Inventaire d'équipement
- **prets_materiel** : Système de prêt
- **documents** : Stockage polymorphique de fichiers
- **consentements** : Consentements RGPD

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

- **Laravel 12.0** (dernière version)
- **PHP 8.2+**
- **MariaDB/MySQL**

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

- Chiffrement des champs sensibles (téléphones, adresses, contacts d'urgence)
- Hachage des mots de passe avec BCRYPT (12 rounds)
- Flag de changement de mot de passe forcé
- Suivi de vérification d'email
- Support de chiffrement de session
- Token "Se souvenir de moi"
- Conformité RGPD avec suivi des consentements

## Localisation

- Interface en français (noms de tables/champs en français)
- Locale par défaut configurable
- Packages Laravel Lang pour traductions

## Sauvegarde

- Système Spatie Backup configuré
- Exclusion automatique de vendor et node_modules

## Tests

Le projet utilise Pest PHP pour les tests :

```bash
# Exécuter tous les tests
php artisan test

# Ou via composer
composer test

# Tests avec couverture
php artisan test --coverage
```

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
