#!/bin/bash

###############################################################################
# Script de configuration du chiffrement MariaDB (Encryption at Rest)
# RGPD Article 32 - Sécurité du traitement
###############################################################################

set -e

echo "🔐 Configuration du chiffrement MariaDB - Lyon Palme"
echo "======================================================"
echo ""

# Vérifier les privilèges root
if [ "$EUID" -ne 0 ]; then 
    echo "❌ Ce script doit être exécuté en tant que root (sudo)"
    exit 1
fi

echo "1️⃣  Génération du fichier de clés de chiffrement..."

# Créer le répertoire si nécessaire
mkdir -p /etc/mysql

# Générer une clé de chiffrement aléatoire (256-bit)
ENCRYPTION_KEY=$(openssl rand -hex 32)

# Créer le fichier de clés avec la clé générée
cat > /etc/mysql/encryption_keyfile << KEYEOF
1;${ENCRYPTION_KEY}
KEYEOF

# Sécuriser le fichier de clés
chmod 600 /etc/mysql/encryption_keyfile
chown mysql:mysql /etc/mysql/encryption_keyfile

echo "   ✓ Fichier de clés créé: /etc/mysql/encryption_keyfile"
echo ""

echo "2️⃣  Création de la configuration MariaDB..."

# Créer le fichier de configuration pour le chiffrement
cat > /etc/mysql/mariadb.conf.d/50-encryption.cnf << CONFEOF
[mysqld]
# ============================================================================
# CHIFFREMENT MARIADB - RGPD COMPLIANT
# ============================================================================

# Plugin de gestion des clés (file_key_management)
plugin-load-add=file_key_management.so
file_key_management_filename = /etc/mysql/encryption_keyfile
file_key_management_encryption_algorithm = AES_CBC

# Chiffrement des tables InnoDB
innodb_encrypt_tables = ON              # Chiffrer toutes les nouvelles tables
innodb_encrypt_log = ON                 # Chiffrer les logs de transactions
innodb_encryption_threads = 4           # Threads pour le chiffrement en arrière-plan
innodb_encryption_rotate_key_age = 1    # Rotation automatique des clés

# Chiffrement des fichiers système
encrypt_binlog = ON                     # Chiffrer les logs binaires
encrypt_tmp_disk_tables = ON            # Chiffrer les tables temporaires sur disque
encrypt_tmp_files = ON                  # Chiffrer les fichiers temporaires

# Chiffrement Aria (moteur de stockage pour tables système)
aria_encrypt_tables = ON
CONFEOF

echo "   ✓ Configuration créée: /etc/mysql/mariadb.conf.d/50-encryption.cnf"
echo ""

echo "3️⃣  Redémarrage de MariaDB..."
systemctl restart mariadb

echo "   ✓ MariaDB redémarré avec succès"
echo ""

echo "4️⃣  Vérification du chiffrement..."

# Vérifier que le plugin est chargé
mysql -e "SHOW PLUGINS;" | grep -i file_key_management > /dev/null
if [ $? -eq 0 ]; then
    echo "   ✓ Plugin file_key_management chargé"
else
    echo "   ❌ Plugin file_key_management non trouvé"
    exit 1
fi

# Vérifier les variables de chiffrement
echo ""
echo "Variables de chiffrement InnoDB:"
mysql -e "SHOW VARIABLES LIKE 'innodb_encrypt%';"

echo ""
echo "✅ Configuration du chiffrement MariaDB terminée!"
echo ""
echo "📋 Prochaines étapes:"
echo "   1. Exécuter le script SQL pour chiffrer les tables existantes"
echo "   2. Sauvegarder le fichier /etc/mysql/encryption_keyfile en lieu sûr"
echo "   3. Configurer la rotation automatique des clés (recommandé)"
echo ""
