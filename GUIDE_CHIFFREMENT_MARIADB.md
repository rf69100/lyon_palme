# 🔐 Guide de Chiffrement MariaDB "At Rest" - Lyon Palme

## 📋 Table des matières

1. [Vue d'ensemble](#vue-densemble)
2. [Prérequis](#prérequis)
3. [Architecture de sécurité](#architecture-de-sécurité)
4. [Installation pas à pas](#installation-pas-à-pas)
5. [Vérification](#vérification)
6. [Maintenance](#maintenance)
7. [Récupération en cas de sinistre](#récupération-en-cas-de-sinistre)
8. [FAQ](#faq)

---

## 📖 Vue d'ensemble

### Qu'est-ce que le chiffrement "at rest" ?

Le chiffrement "at rest" (au repos) protège les données stockées sur le disque dur. Même si quelqu'un accède physiquement aux fichiers de la base de données, les données restent illisibles sans la clé de chiffrement.

### Conformité RGPD

| Article RGPD | Exigence | Implémentation |
|--------------|----------|----------------|
| **Article 32** | Sécurité du traitement | ✅ Chiffrement des données personnelles |
| **Article 25** | Privacy by Design | ✅ Chiffrement par défaut |
| **Article 5(1)(f)** | Intégrité et confidentialité | ✅ Protection contre accès non autorisé |

### Architecture à deux niveaux

```
┌─────────────────────────────────────────────────────────┐
│  NIVEAU 1: Chiffrement Applicatif (Laravel)             │
│  • AES-256-CBC via Crypt::encryptString()               │
│  • Champs sensibles: nom, prenom, email, etc.           │
│  • Protection contre accès SQL direct                   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│  NIVEAU 2: Chiffrement Base de Données (MariaDB)        │
│  • AES-CBC avec file_key_management                     │
│  • Toutes les tables chiffrées sur disque              │
│  • Protection contre accès fichiers physiques           │
└─────────────────────────────────────────────────────────┘
```

---

## ✅ Prérequis

### Logiciels requis

- **MariaDB** 10.1+ (vous avez: 10.11.13 ✓)
- **OpenSSL** pour génération des clés
- **Accès root** au serveur

### Vérification de la version

```bash
mysql --version
# Attendu: mysql  Ver 15.1 Distrib 10.11.13-MariaDB
```

### Espace disque

Le chiffrement ajoute un overhead minimal (~5%) à la taille des fichiers.

```bash
# Vérifier l'espace disponible
df -h /var/lib/mysql
```

### Sauvegarde obligatoire

⚠️ **IMPORTANT**: Effectuer une sauvegarde complète AVANT toute modification.

```bash
# Sauvegarde de la base de données
mysqldump -u root -p lyon_palme > lyon_palme_backup_$(date +%Y%m%d_%H%M%S).sql

# Sauvegarde des fichiers de configuration
sudo tar -czf mysql_config_backup_$(date +%Y%m%d_%H%M%S).tar.gz /etc/mysql/
```

---

## 🏗️ Architecture de sécurité

### Composants du chiffrement

```
/etc/mysql/
├── encryption_keyfile              # ← Fichier de clés (600, mysql:mysql)
└── mariadb.conf.d/
    └── 50-encryption.cnf          # ← Configuration du chiffrement
```

### Flux de chiffrement

```
┌─────────────┐
│ Application │  → Données en clair
└──────┬──────┘
       ↓
┌─────────────┐
│ Laravel     │  → Chiffrement AES-256-CBC (niveau 1)
│ Crypt       │     Clé: APP_KEY
└──────┬──────┘
       ↓
┌─────────────┐
│ MariaDB     │  → Chiffrement AES-CBC (niveau 2)
│ InnoDB      │     Clé: encryption_keyfile
└──────┬──────┘
       ↓
┌─────────────┐
│ Disque Dur  │  → Données doublement chiffrées
└─────────────┘
```

---

## 🚀 Installation pas à pas

### Étape 1: Exécuter le script de configuration

```bash
# Donner les permissions root
sudo ./setup_mariadb_encryption.sh
```

**Ce script effectue:**
1. ✅ Génération d'une clé AES-256 aléatoire
2. ✅ Création du fichier `/etc/mysql/encryption_keyfile`
3. ✅ Sécurisation des permissions (600)
4. ✅ Création de la configuration MariaDB
5. ✅ Redémarrage de MariaDB
6. ✅ Vérification du plugin

**Sortie attendue:**
```
🔐 Configuration du chiffrement MariaDB - Lyon Palme
======================================================

1️⃣  Génération du fichier de clés de chiffrement...
   ✓ Fichier de clés créé: /etc/mysql/encryption_keyfile

2️⃣  Création de la configuration MariaDB...
   ✓ Configuration créée: /etc/mysql/mariadb.conf.d/50-encryption.cnf

3️⃣  Redémarrage de MariaDB...
   ✓ MariaDB redémarré avec succès

4️⃣  Vérification du chiffrement...
   ✓ Plugin file_key_management chargé

✅ Configuration du chiffrement MariaDB terminée!
```

### Étape 2: Vérifier la configuration

```bash
# Vérifier que MariaDB a démarré correctement
sudo systemctl status mariadb

# Vérifier les variables de chiffrement
mysql -u root -p -e "SHOW VARIABLES LIKE 'innodb_encrypt%';"
```

**Sortie attendue:**
```
+---------------------------+-------+
| Variable_name             | Value |
+---------------------------+-------+
| innodb_encrypt_log        | ON    |
| innodb_encrypt_tables     | ON    |
| innodb_encryption_threads | 4     |
+---------------------------+-------+
```

### Étape 3: Chiffrer les tables existantes

```bash
# Exécuter le script SQL
mysql -u root -p lyon_palme < encrypt_existing_tables.sql
```

**Ce script chiffre:**
- ✅ **Phase 1** (6 tables): Données personnelles RGPD
  - adherents, representants_legaux, certificats_medicaux
  - utilisateurs, documents, consentements

- ✅ **Phase 2** (6 tables): Données transactionnelles
  - adhesions, paiements, inscriptions, certifications, prets_materiel

- ✅ **Phase 3** (18 tables): Tables de référence
  - saisons, tarifs, roles, seances, competitions, materiel, etc.

**Durée estimée:** 2-5 minutes pour ~100 adhérents

### Étape 4: Vérification finale

```bash
# Exécuter le script de vérification
./verify_encryption.sh
```

**Sortie attendue:**
```
═══════════════════════════════════════════════════════════════════
  🔍 VÉRIFICATION DU CHIFFREMENT MARIADB - LYON PALME
═══════════════════════════════════════════════════════════════════

1️⃣  Plugin de gestion des clés
✓ Plugin file_key_management installé et actif

2️⃣  Variables de chiffrement InnoDB
✓ innodb_encrypt_tables = ON
✓ innodb_encrypt_log = ON
✓ encrypt_binlog = ON

3️⃣  Tables chiffrées
✓ Table 'adherents' chiffrée (PRIORITÉ HAUTE)
✓ Table 'representants_legaux' chiffrée (PRIORITÉ HAUTE)
✓ Table 'certificats_medicaux' chiffrée (PRIORITÉ HAUTE)
✓ Table 'utilisateurs' chiffrée (PRIORITÉ HAUTE)
✓ Table 'documents' chiffrée (PRIORITÉ HAUTE)
✓ Table 'consentements' chiffrée (PRIORITÉ HAUTE)

📊 Total des tables: 30
🔒 Tables chiffrées: 30
✓ Toutes les tables sont chiffrées

4️⃣  Fichier de clés
✓ Fichier de clés existe: /etc/mysql/encryption_keyfile
✓ Permissions correctes (600)

═══════════════════════════════════════════════════════════════════
  📊 RÉSUMÉ DE LA VÉRIFICATION
═══════════════════════════════════════════════════════════════════

Vérifications réussies: 13 / 13 (100%)

✅ CHIFFREMENT MARIADB: CONFORME RGPD

🔒 Niveaux de chiffrement actifs:
   ✓ Niveau 1: Chiffrement applicatif (Laravel Crypt - AES-256-CBC)
   ✓ Niveau 2: Chiffrement base de données (MariaDB - AES-CBC)
   ✓ Protection complète des données au repos
```

---

## 🔍 Vérification

### Vérification manuelle

```sql
-- Vérifier qu'une table spécifique est chiffrée
SELECT 
    TABLE_NAME,
    CREATE_OPTIONS
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'lyon_palme'
  AND TABLE_NAME = 'adherents';
```

**Résultat attendu:**
```
+-----------+--------------------------------+
| TABLE_NAME| CREATE_OPTIONS                 |
+-----------+--------------------------------+
| adherents | ENCRYPTED=YES ENCRYPTION_KEY_ID=1 |
+-----------+--------------------------------+
```

### Test de lecture des données

```bash
# Les données doivent être lisibles normalement via Laravel
php artisan tinker --execute="echo App\Models\Adherent::first()->nom;"
```

Les données sont automatiquement déchiffrées par MariaDB, puis par Laravel.

---

## 🔧 Maintenance

### Rotation des clés (recommandé annuellement)

```bash
# 1. Générer une nouvelle clé
NEW_KEY=$(openssl rand -hex 32)

# 2. Ajouter la nouvelle clé au fichier
sudo bash -c "echo '2;$NEW_KEY' >> /etc/mysql/encryption_keyfile"

# 3. Configurer la rotation
mysql -u root -p -e "SET GLOBAL innodb_encryption_rotate_key_age = 0;"
mysql -u root -p -e "SET GLOBAL innodb_encryption_rotate_key_age = 1;"
```

### Surveillance

```bash
# Vérifier le statut de rotation des clés
mysql -u root -p -e "SELECT * FROM information_schema.INNODB_TABLESPACES_ENCRYPTION WHERE ENCRYPTION_SCHEME = 1 LIMIT 10;"
```

### Logs

```bash
# Vérifier les logs MariaDB pour les erreurs de chiffrement
sudo tail -f /var/log/mysql/error.log | grep -i encrypt
```

---

## 💾 Récupération en cas de sinistre

### Scénario 1: Perte du fichier de clés

⚠️ **CRITIQUE**: Sans le fichier de clés, les données sont IRRÉCUPÉRABLES.

**Prévention:**
```bash
# Sauvegarder le fichier de clés en lieu sûr
sudo cp /etc/mysql/encryption_keyfile /backup/secure/encryption_keyfile.$(date +%Y%m%d)

# Chiffrer la sauvegarde
gpg --symmetric --cipher-algo AES256 /backup/secure/encryption_keyfile.$(date +%Y%m%d)
```

**Restauration:**
```bash
# 1. Restaurer le fichier de clés
sudo cp /backup/secure/encryption_keyfile.YYYYMMDD /etc/mysql/encryption_keyfile

# 2. Définir les permissions
sudo chmod 600 /etc/mysql/encryption_keyfile
sudo chown mysql:mysql /etc/mysql/encryption_keyfile

# 3. Redémarrer MariaDB
sudo systemctl restart mariadb
```

### Scénario 2: Restauration d'une sauvegarde

```bash
# 1. Restaurer la base de données
mysql -u root -p lyon_palme < lyon_palme_backup.sql

# 2. Re-chiffrer les tables
mysql -u root -p lyon_palme < encrypt_existing_tables.sql

# 3. Vérifier
./verify_encryption.sh
```

### Scénario 3: Migration vers un nouveau serveur

```bash
# Sur l'ancien serveur
mysqldump --single-transaction -u root -p lyon_palme > lyon_palme_export.sql
sudo cp /etc/mysql/encryption_keyfile encryption_keyfile.backup

# Sur le nouveau serveur
sudo ./setup_mariadb_encryption.sh
sudo cp encryption_keyfile.backup /etc/mysql/encryption_keyfile
sudo chmod 600 /etc/mysql/encryption_keyfile
sudo chown mysql:mysql /etc/mysql/encryption_keyfile
mysql -u root -p lyon_palme < lyon_palme_export.sql
```

---

## ❓ FAQ

### Q: Le chiffrement ralentit-il la base de données ?

**R:** L'impact est minimal (< 5% généralement). Le chiffrement/déchiffrement est effectué par le processeur, qui est très performant pour ces opérations avec AES-NI (instructions matérielles).

### Q: Puis-je chercher dans les données chiffrées ?

**R:** Oui ! Le déchiffrement est transparent. Les recherches fonctionnent normalement car MariaDB déchiffre automatiquement les données.

### Q: Que se passe-t-il si je perds le fichier de clés ?

**R:** Les données deviennent irrécupérables. **SAUVEGARDEZ TOUJOURS** le fichier de clés en lieu sûr.

### Q: Comment vérifier que mes données sont vraiment chiffrées ?

**R:** 
```bash
# Arrêter MariaDB
sudo systemctl stop mariadb

# Essayer de lire le fichier de table (vous verrez des données binaires illisibles)
sudo strings /var/lib/mysql/lyon_palme/adherents.ibd | head -20

# Redémarrer MariaDB
sudo systemctl start mariadb
```

### Q: Le chiffrement applicatif Laravel est-il toujours nécessaire ?

**R:** OUI ! Les deux niveaux sont complémentaires :
- **Laravel Crypt** protège contre l'accès SQL direct (ex: injection SQL)
- **MariaDB Encryption** protège contre l'accès aux fichiers physiques

### Q: Combien coûte l'espace disque supplémentaire ?

**R:** Le overhead est d'environ 3-5% de la taille totale de la base.

### Q: Puis-je désactiver le chiffrement plus tard ?

**R:** Oui, mais déconseillé pour la conformité RGPD. Pour désactiver :
```sql
ALTER TABLE nom_table ENCRYPTED=NO;
```

### Q: Le chiffrement affecte-t-il les sauvegardes ?

**R:** Les sauvegardes via `mysqldump` contiennent des données déchiffrées (texte SQL). Les sauvegardes physiques (fichiers .ibd) restent chiffrées.

---

## 📚 Références

- [MariaDB Encryption Documentation](https://mariadb.com/kb/en/data-at-rest-encryption/)
- [RGPD - Article 32](https://www.cnil.fr/fr/reglement-europeen-protection-donnees/chapitre4#Article32)
- [ANSSI - Recommandations de sécurité](https://www.ssi.gouv.fr/uploads/2013/05/anssi-guide-recommandations_de_securite_relatives_a_tls-v1.2.pdf)

---

## 📞 Support

En cas de problème, consultez :
1. Les logs MariaDB: `/var/log/mysql/error.log`
2. Le script de vérification: `./verify_encryption.sh`
3. La documentation officielle MariaDB

---

**Lyon Palme - RGPD Compliant** 🔒
