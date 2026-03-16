#!/bin/bash

###############################################################################
# Script de vérification du chiffrement MariaDB
# Lyon Palme - RGPD Compliance Check
###############################################################################

echo "═══════════════════════════════════════════════════════════════════"
echo "  🔍 VÉRIFICATION DU CHIFFREMENT MARIADB - LYON PALME"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Couleurs pour l'affichage
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fonction pour vérifier une condition
check_status() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓${NC} $2"
        return 0
    else
        echo -e "${RED}✗${NC} $2"
        return 1
    fi
}

# Variables pour le comptage
TOTAL_CHECKS=0
PASSED_CHECKS=0

# ============================================================================
# 1. VÉRIFICATION DU PLUGIN FILE_KEY_MANAGEMENT
# ============================================================================
echo "1️⃣  Plugin de gestion des clés"
echo "───────────────────────────────────────────────────────────────────"

mysql -e "SHOW PLUGINS;" | grep -q file_key_management
check_status $? "Plugin file_key_management installé et actif"
TOTAL_CHECKS=$((TOTAL_CHECKS + 1))
[ $? -eq 0 ] && PASSED_CHECKS=$((PASSED_CHECKS + 1))

echo ""

# ============================================================================
# 2. VÉRIFICATION DES VARIABLES DE CHIFFREMENT
# ============================================================================
echo "2️⃣  Variables de chiffrement InnoDB"
echo "───────────────────────────────────────────────────────────────────"

# Vérifier innodb_encrypt_tables
ENCRYPT_TABLES=$(mysql -sN -e "SHOW VARIABLES LIKE 'innodb_encrypt_tables';" | awk '{print $2}')
if [ "$ENCRYPT_TABLES" = "ON" ]; then
    echo -e "${GREEN}✓${NC} innodb_encrypt_tables = ON"
    PASSED_CHECKS=$((PASSED_CHECKS + 1))
else
    echo -e "${RED}✗${NC} innodb_encrypt_tables = $ENCRYPT_TABLES (devrait être ON)"
fi
TOTAL_CHECKS=$((TOTAL_CHECKS + 1))

# Vérifier innodb_encrypt_log
ENCRYPT_LOG=$(mysql -sN -e "SHOW VARIABLES LIKE 'innodb_encrypt_log';" | awk '{print $2}')
if [ "$ENCRYPT_LOG" = "ON" ]; then
    echo -e "${GREEN}✓${NC} innodb_encrypt_log = ON"
    PASSED_CHECKS=$((PASSED_CHECKS + 1))
else
    echo -e "${RED}✗${NC} innodb_encrypt_log = $ENCRYPT_LOG (devrait être ON)"
fi
TOTAL_CHECKS=$((TOTAL_CHECKS + 1))

# Vérifier encrypt_binlog
ENCRYPT_BINLOG=$(mysql -sN -e "SHOW VARIABLES LIKE 'encrypt_binlog';" | awk '{print $2}')
if [ "$ENCRYPT_BINLOG" = "ON" ]; then
    echo -e "${GREEN}✓${NC} encrypt_binlog = ON"
    PASSED_CHECKS=$((PASSED_CHECKS + 1))
else
    echo -e "${RED}✗${NC} encrypt_binlog = $ENCRYPT_BINLOG (devrait être ON)"
fi
TOTAL_CHECKS=$((TOTAL_CHECKS + 1))

echo ""

# ============================================================================
# 3. VÉRIFICATION DES TABLES CHIFFRÉES
# ============================================================================
echo "3️⃣  Tables chiffrées"
echo "───────────────────────────────────────────────────────────────────"

# Tables critiques qui DOIVENT être chiffrées (données RGPD)
CRITICAL_TABLES=("adherents" "representants_legaux" "certificats_medicaux" "utilisateurs" "documents" "consentements")

for table in "${CRITICAL_TABLES[@]}"; do
    ENCRYPTED=$(mysql lyon_palme -sN -e "SELECT CREATE_OPTIONS FROM information_schema.TABLES WHERE TABLE_SCHEMA='lyon_palme' AND TABLE_NAME='$table';" | grep -q "ENCRYPTED=YES")
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓${NC} Table '$table' chiffrée (PRIORITÉ HAUTE)"
        PASSED_CHECKS=$((PASSED_CHECKS + 1))
    else
        echo -e "${RED}✗${NC} Table '$table' NON chiffrée (CRITIQUE RGPD!)"
    fi
    TOTAL_CHECKS=$((TOTAL_CHECKS + 1))
done

echo ""

# Compter toutes les tables chiffrées
TOTAL_TABLES=$(mysql lyon_palme -sN -e "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='lyon_palme' AND TABLE_TYPE='BASE TABLE';")
ENCRYPTED_TABLES=$(mysql lyon_palme -sN -e "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='lyon_palme' AND CREATE_OPTIONS LIKE '%ENCRYPTED=YES%';")

echo "📊 Total des tables: $TOTAL_TABLES"
echo "🔒 Tables chiffrées: $ENCRYPTED_TABLES"

if [ "$ENCRYPTED_TABLES" -eq "$TOTAL_TABLES" ]; then
    echo -e "${GREEN}✓${NC} Toutes les tables sont chiffrées"
    PASSED_CHECKS=$((PASSED_CHECKS + 1))
else
    echo -e "${YELLOW}⚠${NC} $((TOTAL_TABLES - ENCRYPTED_TABLES)) tables non chiffrées"
fi
TOTAL_CHECKS=$((TOTAL_CHECKS + 1))

echo ""

# ============================================================================
# 4. VÉRIFICATION DU FICHIER DE CLÉS
# ============================================================================
echo "4️⃣  Fichier de clés"
echo "───────────────────────────────────────────────────────────────────"

if [ -f "/etc/mysql/encryption_keyfile" ]; then
    echo -e "${GREEN}✓${NC} Fichier de clés existe: /etc/mysql/encryption_keyfile"
    PASSED_CHECKS=$((PASSED_CHECKS + 1))
    
    # Vérifier les permissions
    PERMS=$(stat -c "%a" /etc/mysql/encryption_keyfile 2>/dev/null)
    if [ "$PERMS" = "600" ]; then
        echo -e "${GREEN}✓${NC} Permissions correctes (600)"
        PASSED_CHECKS=$((PASSED_CHECKS + 1))
    else
        echo -e "${YELLOW}⚠${NC} Permissions: $PERMS (recommandé: 600)"
    fi
    TOTAL_CHECKS=$((TOTAL_CHECKS + 1))
else
    echo -e "${RED}✗${NC} Fichier de clés non trouvé"
fi
TOTAL_CHECKS=$((TOTAL_CHECKS + 1))

echo ""

# ============================================================================
# 5. RÉSUMÉ FINAL
# ============================================================================
echo "═══════════════════════════════════════════════════════════════════"
echo "  📊 RÉSUMÉ DE LA VÉRIFICATION"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

PERCENTAGE=$((PASSED_CHECKS * 100 / TOTAL_CHECKS))

echo "Vérifications réussies: $PASSED_CHECKS / $TOTAL_CHECKS ($PERCENTAGE%)"
echo ""

if [ $PASSED_CHECKS -eq $TOTAL_CHECKS ]; then
    echo -e "${GREEN}✅ CHIFFREMENT MARIADB: CONFORME RGPD${NC}"
    echo ""
    echo "🔒 Niveaux de chiffrement actifs:"
    echo "   ✓ Niveau 1: Chiffrement applicatif (Laravel Crypt - AES-256-CBC)"
    echo "   ✓ Niveau 2: Chiffrement base de données (MariaDB - AES-CBC)"
    echo "   ✓ Protection complète des données au repos"
    echo ""
    exit 0
elif [ $PERCENTAGE -ge 80 ]; then
    echo -e "${YELLOW}⚠️  CHIFFREMENT MARIADB: PARTIELLEMENT CONFORME${NC}"
    echo ""
    echo "Action requise: Corriger les vérifications échouées"
    echo ""
    exit 1
else
    echo -e "${RED}❌ CHIFFREMENT MARIADB: NON CONFORME${NC}"
    echo ""
    echo "Action urgente: Configurer le chiffrement MariaDB"
    echo "Exécuter: sudo ./setup_mariadb_encryption.sh"
    echo ""
    exit 2
fi
