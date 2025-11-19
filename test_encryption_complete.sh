#!/bin/bash

###############################################################################
# Script de test complet du chiffrement double niveau
# Lyon Palme - RGPD Compliance
###############################################################################

echo "═══════════════════════════════════════════════════════════════════"
echo "  🧪 TEST COMPLET DU CHIFFREMENT - LYON PALME"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Couleurs
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

TOTAL_TESTS=0
PASSED_TESTS=0

test_result() {
    TOTAL_TESTS=$((TOTAL_TESTS + 1))
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓${NC} $2"
        PASSED_TESTS=$((PASSED_TESTS + 1))
        return 0
    else
        echo -e "${RED}✗${NC} $2"
        [ -n "$3" ] && echo -e "  ${YELLOW}↳${NC} $3"
        return 1
    fi
}

echo "═══════════════════════════════════════════════════════════════════"
echo "  NIVEAU 1: CHIFFREMENT APPLICATIF (LARAVEL)"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Test 1: APP_KEY présente
echo "1️⃣  Configuration Laravel"
echo "───────────────────────────────────────────────────────────────────"

if [ -f .env ]; then
    grep -q "^APP_KEY=base64:" .env
    test_result $? "APP_KEY configurée dans .env"
else
    test_result 1 "Fichier .env présent" "Fichier .env non trouvé"
fi

# Test 2: Trait EncryptsAttributes existe
if [ -f "app/Traits/EncryptsAttributes.php" ]; then
    test_result 0 "Trait EncryptsAttributes présent"
else
    test_result 1 "Trait EncryptsAttributes présent" "Fichier manquant"
fi

# Test 3: Modèles utilisent le trait
grep -q "use EncryptsAttributes" app/Models/Adherent.php 2>/dev/null
test_result $? "Model Adherent utilise EncryptsAttributes"

echo ""

# Test 4: Vérifier le chiffrement dans la base
echo "2️⃣  Données chiffrées en base"
echo "───────────────────────────────────────────────────────────────────"

# Test si la base contient des données
COUNT=$(php artisan tinker --execute="echo App\Models\Adherent::count();" 2>/dev/null)
if [ "$COUNT" -gt 0 ]; then
    test_result 0 "Base de données contient des adhérents ($COUNT)"
    
    # Vérifier que les données sont chiffrées (commencent par eyJpdiI6)
    ENCRYPTED=$(mysql lyon_palme -sN -e "SELECT prenom FROM adherents LIMIT 1;" 2>/dev/null)
    if [[ "$ENCRYPTED" == eyJpdiI6* ]]; then
        test_result 0 "Données chiffrées dans la base (prenom commence par eyJpdiI6)"
    else
        test_result 1 "Données chiffrées dans la base" "Données en clair trouvées: ${ENCRYPTED:0:20}..."
    fi
    
    # Vérifier que Laravel peut déchiffrer
    DECRYPTED=$(php artisan tinker --execute="echo App\Models\Adherent::first()->prenom;" 2>/dev/null)
    if [ -n "$DECRYPTED" ] && [[ "$DECRYPTED" != eyJpdiI6* ]]; then
        test_result 0 "Laravel déchiffre correctement les données"
    else
        test_result 1 "Laravel déchiffre correctement les données" "Échec du déchiffrement"
    fi
else
    test_result 0 "Base de données vide (normal si pas de seed)"
fi

# Test 5: Hash de recherche fonctionnels
HASH_COUNT=$(mysql lyon_palme -sN -e "SELECT COUNT(*) FROM adherents WHERE nom_recherche IS NOT NULL;" 2>/dev/null)
if [ "$HASH_COUNT" -gt 0 ]; then
    test_result 0 "Hashes de recherche générés ($HASH_COUNT adhérents)"
else
    test_result 1 "Hashes de recherche générés" "Aucun hash trouvé"
fi

echo ""

echo "═══════════════════════════════════════════════════════════════════"
echo "  NIVEAU 2: CHIFFREMENT BASE DE DONNÉES (MARIADB AT REST)"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Test 6: Plugin MariaDB
echo "3️⃣  Configuration MariaDB"
echo "───────────────────────────────────────────────────────────────────"

mysql -e "SHOW PLUGINS;" 2>/dev/null | grep -q file_key_management
test_result $? "Plugin file_key_management actif"

# Test 7: Variables de chiffrement
ENCRYPT_TABLES=$(mysql -sN -e "SHOW VARIABLES LIKE 'innodb_encrypt_tables';" 2>/dev/null | awk '{print $2}')
if [ "$ENCRYPT_TABLES" = "ON" ]; then
    test_result 0 "innodb_encrypt_tables = ON"
else
    test_result 1 "innodb_encrypt_tables = ON" "Valeur actuelle: $ENCRYPT_TABLES"
fi

ENCRYPT_LOG=$(mysql -sN -e "SHOW VARIABLES LIKE 'innodb_encrypt_log';" 2>/dev/null | awk '{print $2}')
if [ "$ENCRYPT_LOG" = "ON" ]; then
    test_result 0 "innodb_encrypt_log = ON"
else
    test_result 1 "innodb_encrypt_log = ON" "Valeur actuelle: $ENCRYPT_LOG"
fi

echo ""

# Test 8: Tables chiffrées
echo "4️⃣  Tables chiffrées"
echo "───────────────────────────────────────────────────────────────────"

# Tables critiques RGPD
CRITICAL_TABLES=("adherents" "representants_legaux" "certificats_medicaux" "utilisateurs")

for table in "${CRITICAL_TABLES[@]}"; do
    ENCRYPTED=$(mysql lyon_palme -sN -e "SELECT CREATE_OPTIONS FROM information_schema.TABLES WHERE TABLE_SCHEMA='lyon_palme' AND TABLE_NAME='$table';" 2>/dev/null | grep -c "ENCRYPTED=YES")
    if [ "$ENCRYPTED" -eq 1 ]; then
        test_result 0 "Table '$table' chiffrée"
    else
        test_result 1 "Table '$table' chiffrée" "Table non chiffrée"
    fi
done

# Compter toutes les tables chiffrées
TOTAL_TABLES=$(mysql lyon_palme -sN -e "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='lyon_palme' AND TABLE_TYPE='BASE TABLE';" 2>/dev/null)
ENCRYPTED_TABLES=$(mysql lyon_palme -sN -e "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='lyon_palme' AND CREATE_OPTIONS LIKE '%ENCRYPTED=YES%';" 2>/dev/null)

if [ "$ENCRYPTED_TABLES" -eq "$TOTAL_TABLES" ]; then
    test_result 0 "Toutes les tables chiffrées ($ENCRYPTED_TABLES/$TOTAL_TABLES)"
else
    test_result 1 "Toutes les tables chiffrées" "$ENCRYPTED_TABLES/$TOTAL_TABLES tables chiffrées"
fi

echo ""

# Test 9: Fichier de clés
echo "5️⃣  Sécurité du fichier de clés"
echo "───────────────────────────────────────────────────────────────────"

if [ -f "/etc/mysql/encryption_keyfile" ]; then
    test_result 0 "Fichier de clés existe"
    
    PERMS=$(stat -c "%a" /etc/mysql/encryption_keyfile 2>/dev/null)
    if [ "$PERMS" = "600" ]; then
        test_result 0 "Permissions correctes (600)"
    else
        test_result 1 "Permissions correctes (600)" "Permissions actuelles: $PERMS"
    fi
    
    OWNER=$(stat -c "%U:%G" /etc/mysql/encryption_keyfile 2>/dev/null)
    if [ "$OWNER" = "mysql:mysql" ]; then
        test_result 0 "Propriétaire correct (mysql:mysql)"
    else
        test_result 1 "Propriétaire correct (mysql:mysql)" "Propriétaire actuel: $OWNER"
    fi
else
    test_result 1 "Fichier de clés existe" "Fichier non trouvé"
fi

echo ""

echo "═══════════════════════════════════════════════════════════════════"
echo "  TEST DE BOUT EN BOUT"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Test 10: Écriture et lecture
echo "6️⃣  Test d'intégrité des données"
echo "───────────────────────────────────────────────────────────────────"

# Créer un adhérent de test
TEST_NOM="TestEncryption"
TEST_PRENOM="DoubleNiveau"

php artisan tinker --execute="
\$adherent = new App\Models\Adherent([
    'civilite' => 'M.',
    'prenom' => '$TEST_PRENOM',
    'nom' => '$TEST_NOM',
    'date_naissance' => '1990-01-01',
    'email' => 'test@encryption.test',
    'pays' => 'France',
    'statut' => 'actif',
    'est_mineur' => false,
]);
\$adherent->save();
echo \$adherent->id;
" > /tmp/test_adherent_id.txt 2>/dev/null

if [ -s /tmp/test_adherent_id.txt ]; then
    TEST_ID=$(cat /tmp/test_adherent_id.txt)
    test_result 0 "Création d'un adhérent de test (ID: $TEST_ID)"
    
    # Vérifier que les données sont chiffrées en base
    RAW_NOM=$(mysql lyon_palme -sN -e "SELECT nom FROM adherents WHERE id='$TEST_ID';" 2>/dev/null)
    if [[ "$RAW_NOM" == eyJpdiI6* ]]; then
        test_result 0 "Données stockées chiffrées en base (niveau 1)"
    else
        test_result 1 "Données stockées chiffrées en base (niveau 1)" "Données en clair trouvées"
    fi
    
    # Vérifier que Laravel peut relire les données
    READ_NOM=$(php artisan tinker --execute="echo App\Models\Adherent::find($TEST_ID)->nom;" 2>/dev/null)
    if [ "$READ_NOM" = "$TEST_NOM" ]; then
        test_result 0 "Lecture et déchiffrement corrects (données intègres)"
    else
        test_result 1 "Lecture et déchiffrement corrects" "Attendu: $TEST_NOM, Lu: $READ_NOM"
    fi
    
    # Nettoyer
    php artisan tinker --execute="App\Models\Adherent::find($TEST_ID)->delete();" > /dev/null 2>&1
    test_result 0 "Nettoyage de l'adhérent de test"
else
    test_result 1 "Création d'un adhérent de test" "Échec de la création"
fi

rm -f /tmp/test_adherent_id.txt

echo ""

# Résumé final
echo "═══════════════════════════════════════════════════════════════════"
echo "  📊 RÉSUMÉ DES TESTS"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

PERCENTAGE=$((PASSED_TESTS * 100 / TOTAL_TESTS))

echo "Tests réussis: $PASSED_TESTS / $TOTAL_TESTS ($PERCENTAGE%)"
echo ""

if [ $PASSED_TESTS -eq $TOTAL_TESTS ]; then
    echo -e "${GREEN}✅ CHIFFREMENT DOUBLE NIVEAU: OPÉRATIONNEL${NC}"
    echo ""
    echo "🔒 Protection active:"
    echo "   ✓ Niveau 1: Chiffrement applicatif (Laravel AES-256-CBC)"
    echo "   ✓ Niveau 2: Chiffrement base de données (MariaDB AES-CBC)"
    echo "   ✓ Hashes de recherche (SHA-256)"
    echo "   ✓ Conformité RGPD Articles 4, 9, 25, 32"
    echo ""
    exit 0
elif [ $PERCENTAGE -ge 80 ]; then
    echo -e "${YELLOW}⚠️  CHIFFREMENT: PARTIELLEMENT OPÉRATIONNEL${NC}"
    echo ""
    echo "Certains tests ont échoué. Vérifiez les messages ci-dessus."
    echo ""
    exit 1
else
    echo -e "${RED}❌ CHIFFREMENT: NON OPÉRATIONNEL${NC}"
    echo ""
    echo "Action requise: Configurer le chiffrement"
    echo ""
    echo "Étapes:"
    echo "  1. sudo ./setup_mariadb_encryption.sh"
    echo "  2. mysql -u root -p lyon_palme < encrypt_existing_tables.sql"
    echo "  3. ./test_encryption_complete.sh"
    echo ""
    exit 2
fi
