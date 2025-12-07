# Changelog - Lyon Palme

Tous les changements notables du projet Lyon Palme seront documentés dans ce fichier.

Le format est basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/),
et ce projet adhère au [Semantic Versioning](https://semver.org/lang/fr/).

## [1.0.0] - 2024-12-07

### Ajouté

#### Fonctionnalités principales
- ✅ Système complet de gestion des adhérents (adultes et mineurs)
- ✅ Gestion des adhésions par saison avec tarification dynamique
- ✅ Suivi des paiements multi-modes (espèces, chèque, virement, carte, Hello Asso)
- ✅ Gestion des certificats médicaux avec alertes d'expiration
- ✅ Système de certifications FFESSM (plongée, apnée, nage avec palmes, moniteurs)
- ✅ Planification et gestion des entraînements
- ✅ Organisation des compétitions régionales et nationales
- ✅ Gestion des sorties/excursions du club
- ✅ Inventaire et prêt de matériel
- ✅ Système de gestion documentaire polymorphique

#### Sécurité et Conformité
- ✅ Chiffrement AES-256 des données sensibles (27 champs)
- ✅ Conformité RGPD complète avec gestion des consentements
- ✅ Conformité CNIL avec politique de mots de passe stricte
- ✅ Audit trail complet des actions utilisateurs
- ✅ Protection contre SQL Injection, XSS, CSRF
- ✅ Rate limiting sur authentification
- ✅ Vérification email obligatoire

#### Interface Utilisateur
- ✅ Page d'accueil avec présentation du club
- ✅ Formulaire d'inscription avec consentements RGPD obligatoires
- ✅ Dashboard avec statistiques du club
- ✅ 8 pages légales complètes (Documentation, Support, RGPD, CNIL, Confidentialité, Conditions, Cookies)
- ✅ Design responsive avec Tailwind CSS 4
- ✅ Thème clair uniforme sur toutes les pages

#### Système de Rôles
- ✅ 11 rôles prédéfinis (Président, Vice-président, Secrétaire, Trésorier, etc.)
- ✅ Système de permissions granulaire avec Spatie Laravel Permission
- ✅ Annuaire du bureau avec visibilité configurable

#### Base de Données
- ✅ 27 tables avec indexation optimisée
- ✅ Vue SQL pour le statut des adhésions
- ✅ Migrations et seeders complets
- ✅ Support MariaDB/MySQL

### Technique

#### Backend
- Laravel 12.0
- PHP 8.2+
- MariaDB avec chiffrement de champs

#### Frontend
- Tailwind CSS 4.0.0
- Vite 7.0.7
- Blade templating
- Axios 1.11.0

#### Packages Principaux
- spatie/laravel-permission - Gestion des rôles
- spatie/laravel-medialibrary - Gestion des médias
- spatie/laravel-backup - Sauvegardes automatisées
- maatwebsite/excel - Import/export Excel
- soved/laravel-gdpr - Conformité RGPD

#### Développement
- Laravel Telescope - Débogage
- Laravel Pail - Logs en temps réel
- Pest PHP - Tests modernes
- Laravel Pint - Formatage PSR-12

### Modifié

- 🔄 Clarification que l'application est exclusive au club Lyon Palme
- 🔄 Mise à jour de tous les textes pour refléter l'identité du club
- 🔄 Footer de toutes les pages avec informations du club (Centre Nautique de Vénissieux, FFESSM AURA)

### Sécurisé

- 🔒 Politique de mot de passe CNIL (12+ caractères, complexité, expiration 90j)
- 🔒 Sessions sécurisées (HttpOnly, Secure, SameSite)
- 🔒 Headers de sécurité (CSP, HSTS, X-Frame-Options, etc.)
- 🔒 Sanitization automatique des entrées
- 🔒 Validation stricte des uploads de fichiers

### Documentation

- 📚 README.md complet avec guide d'installation
- 📚 SECURITY.md avec politique de sécurité
- 📚 CHANGELOG.md pour le suivi des versions
- 📚 8 pages légales en français
- 📚 Commentaires de code en français

---

## Format des Versions

Le projet suit le Semantic Versioning (MAJOR.MINOR.PATCH) :
- **MAJOR** : Changements incompatibles de l'API
- **MINOR** : Ajout de fonctionnalités rétrocompatibles
- **PATCH** : Corrections de bugs rétrocompatibles

## Types de Changements

- `Ajouté` - Nouvelles fonctionnalités
- `Modifié` - Changements de fonctionnalités existantes
- `Déprécié` - Fonctionnalités bientôt supprimées
- `Supprimé` - Fonctionnalités supprimées
- `Corrigé` - Corrections de bugs
- `Sécurisé` - Vulnérabilités corrigées

---

**Application développée exclusivement pour le club Lyon Palme**
FFESSM - Comité Régional AURA - Centre Nautique de Vénissieux
