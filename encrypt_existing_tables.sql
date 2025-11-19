-- ============================================================================
-- CHIFFREMENT DES TABLES EXISTANTES - Lyon Palme
-- RGPD Article 32 - Sécurité du traitement
-- ============================================================================
--
-- Ce script chiffre toutes les tables existantes de la base de données
-- avec le chiffrement "at rest" de MariaDB.
--
-- ⚠️ IMPORTANT: 
-- - Exécuter ce script après avoir configuré le chiffrement MariaDB
-- - Une sauvegarde complète est recommandée avant l'exécution
-- - L'opération peut prendre du temps selon la taille de la base
--
-- Usage: mysql -u root -p lyon_palme < encrypt_existing_tables.sql
-- ============================================================================

USE lyon_palme;

SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- Afficher les informations de démarrage
SELECT '═══════════════════════════════════════════════════════════════════' AS '';
SELECT '  🔐 CHIFFREMENT DES TABLES LYON PALME - RGPD COMPLIANCE' AS '';
SELECT '═══════════════════════════════════════════════════════════════════' AS '';
SELECT '' AS '';

-- ============================================================================
-- TABLES CONTENANT DES DONNÉES PERSONNELLES (PRIORITÉ HAUTE)
-- ============================================================================

SELECT '📋 PHASE 1: Tables avec données personnelles (RGPD Art. 4 & 9)' AS '';
SELECT '─────────────────────────────────────────────────────────────────' AS '';

-- Adherents (données personnelles + santé)
SELECT '  → Chiffrement: adherents' AS '';
ALTER TABLE adherents ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Representants légaux (données personnelles)
SELECT '  → Chiffrement: representants_legaux' AS '';
ALTER TABLE representants_legaux ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Certificats médicaux (données de santé - Article 9)
SELECT '  → Chiffrement: certificats_medicaux' AS '';
ALTER TABLE certificats_medicaux ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Utilisateurs (authentification)
SELECT '  → Chiffrement: utilisateurs' AS '';
ALTER TABLE utilisateurs ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Documents (peuvent contenir des données sensibles)
SELECT '  → Chiffrement: documents' AS '';
ALTER TABLE documents ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Consentements (traçabilité RGPD)
SELECT '  → Chiffrement: consentements' AS '';
ALTER TABLE consentements ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '' AS '';
SELECT '✓ Phase 1 terminée - 6 tables chiffrées' AS '';
SELECT '' AS '';

-- ============================================================================
-- TABLES TRANSACTIONNELLES ET RELATIONNELLES (PRIORITÉ MOYENNE)
-- ============================================================================

SELECT '📋 PHASE 2: Tables transactionnelles' AS '';
SELECT '─────────────────────────────────────────────────────────────────' AS '';

-- Adhésions et paiements
SELECT '  → Chiffrement: adhesions' AS '';
ALTER TABLE adhesions ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: paiements' AS '';
ALTER TABLE paiements ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Inscriptions
SELECT '  → Chiffrement: inscriptions_sorties' AS '';
ALTER TABLE inscriptions_sorties ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: inscriptions_competitions' AS '';
ALTER TABLE inscriptions_competitions ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Certifications
SELECT '  → Chiffrement: certifications' AS '';
ALTER TABLE certifications ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Prêts de matériel
SELECT '  → Chiffrement: prets_materiel' AS '';
ALTER TABLE prets_materiel ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '' AS '';
SELECT '✓ Phase 2 terminée - 6 tables supplémentaires chiffrées' AS '';
SELECT '' AS '';

-- ============================================================================
-- TABLES DE RÉFÉRENCE ET CONFIGURATION (PRIORITÉ BASSE)
-- ============================================================================

SELECT '📋 PHASE 3: Tables de référence et configuration' AS '';
SELECT '─────────────────────────────────────────────────────────────────' AS '';

-- Saisons et tarifs
SELECT '  → Chiffrement: saisons' AS '';
ALTER TABLE saisons ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: tarifs' AS '';
ALTER TABLE tarifs ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: types_adhesion' AS '';
ALTER TABLE types_adhesion ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Rôles et permissions
SELECT '  → Chiffrement: roles' AS '';
ALTER TABLE roles ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: adherent_roles' AS '';
ALTER TABLE adherent_roles ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Activités
SELECT '  → Chiffrement: seances_entrainement' AS '';
ALTER TABLE seances_entrainement ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: seance_entraineurs' AS '';
ALTER TABLE seance_entraineurs ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: programmes_entrainement' AS '';
ALTER TABLE programmes_entrainement ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: seance_programmes' AS '';
ALTER TABLE seance_programmes ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: sorties' AS '';
ALTER TABLE sorties ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: competitions' AS '';
ALTER TABLE competitions ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: modalites_competition' AS '';
ALTER TABLE modalites_competition ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Matériel
SELECT '  → Chiffrement: types_materiel' AS '';
ALTER TABLE types_materiel ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: inventaire_materiel' AS '';
ALTER TABLE inventaire_materiel ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

-- Tables système
SELECT '  → Chiffrement: jetons_reinitialisation_mdp' AS '';
ALTER TABLE jetons_reinitialisation_mdp ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: journaux_connexion' AS '';
ALTER TABLE journaux_connexion ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: sessions' AS '';
ALTER TABLE sessions ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '  → Chiffrement: migrations' AS '';
ALTER TABLE migrations ENCRYPTED=YES ENCRYPTION_KEY_ID=1;

SELECT '' AS '';
SELECT '✓ Phase 3 terminée - 18 tables supplémentaires chiffrées' AS '';
SELECT '' AS '';

-- ============================================================================
-- VÉRIFICATION FINALE
-- ============================================================================

SELECT '═══════════════════════════════════════════════════════════════════' AS '';
SELECT '  📊 VÉRIFICATION DU CHIFFREMENT' AS '';
SELECT '═══════════════════════════════════════════════════════════════════' AS '';
SELECT '' AS '';

-- Compter les tables chiffrées
SELECT 
    COUNT(*) AS tables_chiffrees,
    'Tables avec ENCRYPTED=YES' AS description
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'lyon_palme'
  AND CREATE_OPTIONS LIKE '%ENCRYPTED=YES%';

SELECT '' AS '';

-- Afficher toutes les tables et leur statut de chiffrement
SELECT '📋 Statut de chiffrement par table:' AS '';
SELECT '─────────────────────────────────────────────────────────────────' AS '';

SELECT 
    TABLE_NAME AS 'Table',
    CASE 
        WHEN CREATE_OPTIONS LIKE '%ENCRYPTED=YES%' THEN '✓ CHIFFRÉ'
        ELSE '✗ NON CHIFFRÉ'
    END AS 'Statut',
    CASE 
        WHEN TABLE_NAME IN ('adherents', 'representants_legaux', 'certificats_medicaux', 'utilisateurs') 
        THEN '⚠️ DONNÉES SENSIBLES'
        ELSE ''
    END AS 'Priorité'
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'lyon_palme'
  AND TABLE_TYPE = 'BASE TABLE'
ORDER BY 
    CASE 
        WHEN TABLE_NAME IN ('adherents', 'representants_legaux', 'certificats_medicaux') THEN 1
        WHEN TABLE_NAME IN ('utilisateurs', 'adhesions', 'paiements') THEN 2
        ELSE 3
    END,
    TABLE_NAME;

SELECT '' AS '';
SELECT '═══════════════════════════════════════════════════════════════════' AS '';
SELECT '  ✅ CHIFFREMENT "AT REST" TERMINÉ' AS '';
SELECT '═══════════════════════════════════════════════════════════════════' AS '';
SELECT '' AS '';
SELECT '📋 Résumé:' AS '';
SELECT '   • Toutes les tables de la base lyon_palme sont chiffrées' AS '';
SELECT '   • Algorithme: AES-CBC avec clé 256-bit' AS '';
SELECT '   • Conformité: RGPD Article 32 (Sécurité du traitement) ✓' AS '';
SELECT '' AS '';
SELECT '⚠️  Actions recommandées:' AS '';
SELECT '   1. Sauvegarder /etc/mysql/encryption_keyfile en lieu sûr' AS '';
SELECT '   2. Mettre en place la rotation des clés (recommandé annuellement)' AS '';
SELECT '   3. Documenter la procédure de restauration en cas de sinistre' AS '';
SELECT '   4. Tester la sauvegarde et restauration des données chiffrées' AS '';
SELECT '' AS '';

SET SQL_MODE=@OLD_SQL_MODE;
