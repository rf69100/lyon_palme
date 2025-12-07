# Politique de Sécurité - Lyon Palme

## Signalement de Vulnérabilités

Le club Lyon Palme prend la sécurité de cette plateforme très au sérieux. Si vous découvrez une vulnérabilité de sécurité, merci de nous en informer de manière responsable.

### Comment Signaler

**⚠️ NE PAS créer d'issue publique GitHub pour les vulnérabilités de sécurité.**

Pour signaler une vulnérabilité de sécurité, veuillez envoyer un email à :
- **Email de sécurité :** security@lyonpalme.fr
- **DPO (Délégué à la Protection des Données) :** dpo@lyonpalme.fr

Votre email devrait inclure :
- Description détaillée de la vulnérabilité
- Étapes pour reproduire le problème
- Impact potentiel
- Suggestions de correction (si disponibles)

### Temps de Réponse

- **Accusé de réception :** Sous 48 heures
- **Analyse initiale :** Sous 5 jours ouvrés
- **Mise à jour régulière :** Toutes les semaines jusqu'à résolution
- **Correction :** Selon la criticité (voir ci-dessous)

### Niveaux de Criticité

| Criticité | Délai de correction | Exemples |
|-----------|---------------------|----------|
| 🔴 Critique | 24-48 heures | Accès non autorisé aux données, injection SQL, XSS critique |
| 🟠 Élevée | 7 jours | Élévation de privilèges, fuite de données sensibles |
| 🟡 Moyenne | 30 jours | Contournement de validation, CSRF mineur |
| 🟢 Faible | 90 jours | Problèmes d'information divulguée, headers manquants |

## Mesures de Sécurité en Place

### Chiffrement des Données

- **Données sensibles chiffrées** : 27 champs avec AES-256-CBC
- **Transport sécurisé** : TLS 1.3 obligatoire en production
- **Mots de passe** : Hashage BCRYPT avec 12+ rounds
- **Clés** : Rotation régulière des clés d'application

### Authentification et Contrôle d'Accès

- **Politique de mot de passe CNIL** :
  - Minimum 12 caractères
  - Majuscules, minuscules, chiffres, symboles requis
  - Expiration après 90 jours
  - Historique (pas de réutilisation des 5 derniers)
- **Rate limiting** : 5 tentatives par minute (email/IP)
- **Vérification email** : Obligatoire avant accès
- **Session sécurisée** : HttpOnly, Secure, SameSite=Lax

### Protection contre les Attaques

- **SQL Injection** : Requêtes paramétrées (Eloquent ORM)
- **XSS** : Blade escaping automatique + sanitization
- **CSRF** : Tokens automatiques sur POST/PUT/DELETE
- **Clickjacking** : X-Frame-Options: DENY
- **MIME Sniffing** : X-Content-Type-Options: nosniff

### Audit et Traçabilité

- **Audit logs** : Toutes les actions critiques enregistrées
- **Données tracées** : Utilisateur, action, IP, User-Agent, timestamp
- **Rétention** : 12 mois minimum
- **Non-répudiation** : Impossible de nier une action

### RGPD et Confidentialité

- **Conformité RGPD** : Intégrale
- **Consentements** : Traçables avec IP et date
- **Droit à l'oubli** : Implémenté
- **Portabilité** : Export JSON disponible
- **DPO** : Délégué à la Protection des Données désigné

### Sauvegardes

- **Fréquence** : Quotidiennes automatiques
- **Chiffrement** : AES-256 pour toutes les sauvegardes
- **Stockage** : Redondance géographique
- **Rétention** : 30 jours minimum
- **Test de restauration** : Mensuel

## Versions Supportées

| Version | Support Sécurité |
|---------|------------------|
| 1.x     | ✅ Support actif |
| < 1.0   | ❌ Non supporté  |

## Mises à Jour de Sécurité

Les mises à jour de sécurité sont publiées dès que possible après la vérification :

1. **Correction développée et testée**
2. **Déploiement en environnement de test**
3. **Validation par l'équipe de sécurité**
4. **Déploiement en production**
5. **Notification aux utilisateurs** (selon criticité)

## Contact

Pour toute question concernant la sécurité :

- **Email sécurité :** security@lyonpalme.fr
- **DPO :** dpo@lyonpalme.fr
- **Support général :** support@lyonpalme.fr

## Remerciements

Nous remercions chaleureusement tous les chercheurs en sécurité qui signalent de manière responsable les vulnérabilités découvertes.

---

**Dernière mise à jour :** Décembre 2024
