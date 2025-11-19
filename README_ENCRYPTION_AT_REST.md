# 🔐 Chiffrement "At Rest" MariaDB - Lyon Palme

## 📦 Fichiers créés

Ce dossier contient tous les scripts et la documentation nécessaires pour implémenter le chiffrement "at rest" de MariaDB, conformément au RGPD Article 32.

```
.
├── README_ENCRYPTION_AT_REST.md         # Ce fichier (vue d'ensemble)
├── GUIDE_CHIFFREMENT_MARIADB.md         # Documentation complète détaillée
├── setup_mariadb_encryption.sh          # Script d'installation principal
├── encrypt_existing_tables.sql          # Script SQL pour chiffrer les tables
└── verify_encryption.sh                 # Script de vérification
```

---

## 🚀 Démarrage rapide

### Étape 1: Sauvegarde (OBLIGATOIRE)

```bash
# Sauvegarder la base de données
mysqldump -u root -p lyon_palme > lyon_palme_backup_$(date +%Y%m%d_%H%M%S).sql

# Sauvegarder la configuration MySQL
sudo tar -czf mysql_config_backup_$(date +%Y%m%d_%H%M%S).tar.gz /etc/mysql/
```

### Étape 2: Installation du chiffrement

```bash
# Exécuter le script de configuration (nécessite root)
sudo ./setup_mariadb_encryption.sh
```

**Sortie attendue:**
```
🔐 Configuration du chiffrement MariaDB - Lyon Palme
======================================================
1️⃣  Génération du fichier de clés de chiffrement...
   ✓ Fichier de clés créé
2️⃣  Création de la configuration MariaDB...
   ✓ Configuration créée
3️⃣  Redémarrage de MariaDB...
   ✓ MariaDB redémarré avec succès
4️⃣  Vérification du chiffrement...
   ✓ Plugin file_key_management chargé
✅ Configuration terminée!
```

### Étape 3: Chiffrement des tables existantes

```bash
# Chiffrer toutes les tables de la base lyon_palme
mysql -u root -p lyon_palme < encrypt_existing_tables.sql
```

**Durée:** 2-5 minutes pour ~100 adhérents

### Étape 4: Vérification

```bash
# Vérifier que tout est correctement configuré
./verify_encryption.sh
```

**Résultat attendu:** `✅ CHIFFREMENT MARIADB: CONFORME RGPD`

---

## 📊 Architecture de sécurité

### Double chiffrement (Defense in Depth)

```
┌────────────────────────────────────────────────────────────┐
│ NIVEAU 1: Chiffrement Applicatif                           │
│ ─────────────────────────────────────────────────────────  │
│ • Laravel Crypt::encryptString()                           │
│ • AES-256-CBC                                              │
│ • Clé: APP_KEY (.env)                                      │
│ • Champs: nom, prenom, email, telephone, etc.              │
│                                                            │
│ Protection: Accès SQL direct, injection SQL                │
└────────────────────────────────────────────────────────────┘
                            ↓
┌────────────────────────────────────────────────────────────┐
│ NIVEAU 2: Chiffrement Base de Données (AT REST)           │
│ ─────────────────────────────────────────────────────────  │
│ • MariaDB file_key_management                              │
│ • AES-CBC                                                  │
│ • Clé: /etc/mysql/encryption_keyfile                       │
│ • Tables: TOUTES (30 tables)                              │
│                                                            │
│ Protection: Accès fichiers physiques, vol de disque       │
└────────────────────────────────────────────────────────────┘
```

### Conformité RGPD

| Article | Exigence | ✅ Implémenté |
|---------|----------|--------------|
| **Article 5(1)(f)** | Intégrité et confidentialité | Double chiffrement |
| **Article 25** | Privacy by Design | Chiffrement par défaut |
| **Article 32** | Sécurité du traitement | AES-256 + AES-CBC |

---

## 📖 Description des fichiers

### 1. `setup_mariadb_encryption.sh`

**Fonction:** Configure automatiquement le chiffrement MariaDB

**Actions:**
- ✅ Génère une clé AES-256 aléatoire
- ✅ Crée `/etc/mysql/encryption_keyfile`
- ✅ Configure les permissions (600, mysql:mysql)
- ✅ Crée `/etc/mysql/mariadb.conf.d/50-encryption.cnf`
- ✅ Redémarre MariaDB
- ✅ Vérifie le plugin file_key_management

**Utilisation:**
```bash
sudo ./setup_mariadb_encryption.sh
```

**Prérequis:** Accès root

---

### 2. `encrypt_existing_tables.sql`

**Fonction:** Chiffre toutes les tables de la base lyon_palme

**Tables chiffrées (30 au total):**

**Phase 1 - Données RGPD critiques (6 tables):**
- `adherents` - Données personnelles Art. 4
- `representants_legaux` - Données personnelles Art. 4  
- `certificats_medicaux` - Données santé Art. 9
- `utilisateurs` - Authentification
- `documents` - Fichiers sensibles
- `consentements` - Traçabilité RGPD

**Phase 2 - Transactions (6 tables):**
- `adhesions`, `paiements`
- `inscriptions_sorties`, `inscriptions_competitions`
- `certifications`, `prets_materiel`

**Phase 3 - Référence (18 tables):**
- Tables de configuration, saisons, tarifs, rôles, etc.

**Utilisation:**
```bash
mysql -u root -p lyon_palme < encrypt_existing_tables.sql
```

**Sortie:** Rapport détaillé avec statut de chaque table

---

### 3. `verify_encryption.sh`

**Fonction:** Vérifie la conformité du chiffrement

**Vérifications effectuées:**
1. ✅ Plugin file_key_management actif
2. ✅ Variables innodb_encrypt_* = ON
3. ✅ Tables critiques chiffrées (RGPD)
4. ✅ Toutes les tables chiffrées
5. ✅ Fichier de clés présent et sécurisé

**Utilisation:**
```bash
./verify_encryption.sh
```

**Codes de sortie:**
- `0` : Conformité 100% ✅
- `1` : Conformité partielle (>80%) ⚠️
- `2` : Non conforme (<80%) ❌

---

### 4. `GUIDE_CHIFFREMENT_MARIADB.md`

**Fonction:** Documentation complète et détaillée

**Contenu:**
- 📖 Vue d'ensemble et architecture
- ✅ Prérequis et vérifications
- 🚀 Installation pas à pas avec exemples
- 🔍 Procédures de vérification
- 🔧 Maintenance et rotation des clés
- 💾 Récupération en cas de sinistre
- ❓ FAQ (15 questions/réponses)
- 📚 Références officielles

---

## ⚠️ Points importants

### 🔴 CRITIQUE: Sauvegarde du fichier de clés

Le fichier `/etc/mysql/encryption_keyfile` est **ESSENTIEL**. Sans lui, les données sont **IRRÉCUPÉRABLES**.

**Actions obligatoires:**

```bash
# 1. Sauvegarder immédiatement après création
sudo cp /etc/mysql/encryption_keyfile /backup/secure/encryption_keyfile.$(date +%Y%m%d)

# 2. Chiffrer la sauvegarde
gpg --symmetric --cipher-algo AES256 /backup/secure/encryption_keyfile.$(date +%Y%m%d)

# 3. Stocker en lieu sûr (hors serveur)
# - Coffre-fort physique
# - Gestionnaire de secrets (Vault, AWS Secrets Manager)
# - Stockage chiffré cloud
```

### 🟡 Permissions critiques

```bash
# Fichier de clés
/etc/mysql/encryption_keyfile
  ├── Permissions: 600 (rw-------)
  └── Propriétaire: mysql:mysql

# Configuration
/etc/mysql/mariadb.conf.d/50-encryption.cnf
  ├── Permissions: 644 (rw-r--r--)
  └── Propriétaire: root:root
```

### 🟢 Tests recommandés

Après l'installation, testez :

```bash
# 1. Arrêter MariaDB
sudo systemctl stop mariadb

# 2. Essayer de lire les fichiers .ibd (devrait être illisible)
sudo strings /var/lib/mysql/lyon_palme/adherents.ibd | head

# 3. Redémarrer et vérifier l'accès normal
sudo systemctl start mariadb
php artisan tinker --execute="echo App\Models\Adherent::first()->nom;"
```

---

## 🔧 Maintenance

### Rotation annuelle des clés (recommandé)

```bash
# Générer une nouvelle clé
NEW_KEY=$(openssl rand -hex 32)

# Ajouter au fichier de clés
sudo bash -c "echo '2;$NEW_KEY' >> /etc/mysql/encryption_keyfile"

# Déclencher la rotation
mysql -u root -p -e "SET GLOBAL innodb_encryption_rotate_key_age = 0;"
mysql -u root -p -e "SET GLOBAL innodb_encryption_rotate_key_age = 1;"
```

### Monitoring

```bash
# Vérifier le statut quotidiennement
./verify_encryption.sh

# Surveiller les logs
sudo tail -f /var/log/mysql/error.log | grep -i encrypt
```

---

## 📈 Impact sur les performances

| Métrique | Impact | Note |
|----------|--------|------|
| **Stockage** | +3-5% | Overhead minimal |
| **CPU** | +2-5% | AES-NI hardware acceleration |
| **Requêtes SELECT** | +1-3% | Déchiffrement transparent |
| **Requêtes INSERT** | +2-4% | Chiffrement à l'écriture |

**Conclusion:** Impact négligeable pour une sécurité maximale ✅

---

## 🆘 Dépannage

### Problème: MariaDB ne démarre pas après configuration

```bash
# Vérifier les logs
sudo tail -100 /var/log/mysql/error.log

# Vérifier le plugin
mysql -u root -p -e "SHOW PLUGINS;" | grep file_key

# Si le plugin n'est pas trouvé, vérifier l'installation
dpkg -l | grep mariadb-plugin
```

### Problème: Tables non chiffrées

```bash
# Re-exécuter le script SQL
mysql -u root -p lyon_palme < encrypt_existing_tables.sql

# Vérifier une table spécifique
mysql -u root -p -e "SELECT CREATE_OPTIONS FROM information_schema.TABLES WHERE TABLE_SCHEMA='lyon_palme' AND TABLE_NAME='adherents';"
```

### Problème: Permissions incorrectes

```bash
# Corriger les permissions du fichier de clés
sudo chown mysql:mysql /etc/mysql/encryption_keyfile
sudo chmod 600 /etc/mysql/encryption_keyfile

# Redémarrer MariaDB
sudo systemctl restart mariadb
```

---

## 📞 Support

**Documentation détaillée:** Consultez `GUIDE_CHIFFREMENT_MARIADB.md`

**Vérification rapide:**
```bash
./verify_encryption.sh
```

**Logs:**
```bash
sudo journalctl -u mariadb -f
```

---

## ✅ Checklist de mise en production

- [ ] Sauvegarde complète effectuée
- [ ] `setup_mariadb_encryption.sh` exécuté avec succès
- [ ] Fichier de clés sauvegardé en lieu sûr
- [ ] `encrypt_existing_tables.sql` exécuté
- [ ] `verify_encryption.sh` retourne 100%
- [ ] Tests de lecture/écriture effectués
- [ ] Documentation lue et comprise
- [ ] Procédure de restauration testée
- [ ] Monitoring configuré

---

**🔒 Lyon Palme - RGPD Compliant**

*Chiffrement à double niveau : Laravel AES-256-CBC + MariaDB AES-CBC*
