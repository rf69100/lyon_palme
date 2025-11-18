-- ============================================================================
-- SCHÉMA DE BASE DE DONNÉES LYON PALME
-- Version: 2.0 - Sécurisée Laravel 12
-- SGBD: MariaDB 11.x
-- Note: Les données de base (rôles, types) seront insérées via les seeders Laravel
-- ============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================================
-- 1. TABLES AUTHENTIFICATION ET SÉCURITÉ
-- ============================================================================

-- Table utilisateurs
CREATE TABLE `utilisateurs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(191) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `email_verifie_le` TIMESTAMP NULL DEFAULT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL COMMENT 'Hashé avec bcrypt',
    `jeton_souvenir` VARCHAR(100) NULL DEFAULT NULL,
    `doit_changer_mdp` TINYINT(1) DEFAULT 1,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `utilisateurs_email_unique` (`email`),
    KEY `idx_utilisateurs_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table jetons_reinitialisation_mdp
CREATE TABLE `jetons_reinitialisation_mdp` (
    `email` VARCHAR(191) PRIMARY KEY,
    `jeton` VARCHAR(255) NOT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table journaux_connexion (traçabilité)
CREATE TABLE `journaux_connexion` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `utilisateur_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `email` VARCHAR(191) NOT NULL,
    `adresse_ip` VARCHAR(45) NOT NULL,
    `agent_utilisateur` TEXT NOT NULL,
    `connexion_reussie` TINYINT(1) DEFAULT 1,
    `deconnexion_le` TIMESTAMP NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_journaux_connexion_utilisateur` (`utilisateur_id`),
    KEY `idx_journaux_connexion_cree` (`cree_le`),
    CONSTRAINT `fk_journaux_connexion_utilisateur` 
        FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 2. TABLES SAISONS ET RÉFÉRENTIELS
-- ============================================================================

-- Table saisons
CREATE TABLE `saisons` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(80) NOT NULL,
    `date_debut` DATE NOT NULL,
    `date_fin` DATE NOT NULL,
    `est_courante` TINYINT(1) DEFAULT 0,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `saisons_nom_unique` (`nom`),
    KEY `idx_saisons_courante` (`est_courante`),
    CONSTRAINT `chk_dates_saison` CHECK (`date_fin` > `date_debut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table roles
CREATE TABLE `roles` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(80) NOT NULL,
    `nom_affichage` VARCHAR(120) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `afficher_annuaire` TINYINT(1) DEFAULT 0,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `roles_nom_unique` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table types_adhesion
CREATE TABLE `types_adhesion` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(80) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `necessite_justificatif` TINYINT(1) DEFAULT 0,
    `est_actif` TINYINT(1) DEFAULT 1,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 3. TABLES ADHÉRENTS
-- ============================================================================

-- Table adherents
CREATE TABLE `adherents` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `utilisateur_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `civilite` VARCHAR(10) NOT NULL,
    `prenom` VARCHAR(80) NOT NULL,
    `nom` VARCHAR(80) NOT NULL,
    `date_naissance` DATE NOT NULL,
    `email` VARCHAR(191) NULL DEFAULT NULL,
    `telephone` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `mobile` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `numero_rue` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `rue` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `complement_adresse` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `code_postal` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `ville` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `pays` VARCHAR(80) DEFAULT 'France',
    `chemin_photo` VARCHAR(255) NULL DEFAULT NULL,
    `contact_urgence_nom` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `contact_urgence_telephone` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `contact_urgence_lien` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `statut` VARCHAR(32) DEFAULT 'actif',
    `archive_le` TIMESTAMP NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    `est_mineur` TINYINT(1) DEFAULT NULL,
    KEY `idx_adherents_statut` (`statut`),
    KEY `idx_adherents_email` (`email`),
    KEY `idx_adherents_mineur` (`est_mineur`),
    KEY `idx_adherents_nom` (`nom`, `prenom`),
    CONSTRAINT `fk_adherents_utilisateur` 
        FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table representants_legaux
CREATE TABLE `representants_legaux` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `adherent_mineur_id` BIGINT UNSIGNED NOT NULL,
    `civilite` VARCHAR(10) NOT NULL,
    `prenom` VARCHAR(80) NOT NULL,
    `nom` VARCHAR(80) NOT NULL,
    `lien_parente` VARCHAR(50) NOT NULL,
    `email` VARCHAR(191) NULL DEFAULT NULL,
    `telephone` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `mobile` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `numero_rue` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `rue` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `complement_adresse` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `code_postal` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `ville` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `pays` VARCHAR(80) DEFAULT 'France',
    `est_principal` TINYINT(1) DEFAULT 0,
    `peut_recuperer` TINYINT(1) DEFAULT 1,
    `autorise_sortie` TINYINT(1) DEFAULT 1,
    `autorise_transport` TINYINT(1) DEFAULT 1,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_representants_legaux_mineur` (`adherent_mineur_id`),
    CONSTRAINT `fk_representants_legaux_adherent` 
        FOREIGN KEY (`adherent_mineur_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table adherent_roles
CREATE TABLE `adherent_roles` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    `saison_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `attribue_le` DATE NULL DEFAULT NULL,
    `revoque_le` DATE NULL DEFAULT NULL,
    `est_actif` TINYINT(1) DEFAULT 1,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `adherent_roles_unique` (`adherent_id`, `role_id`, `saison_id`),
    KEY `idx_adherent_roles_adherent` (`adherent_id`),
    KEY `idx_adherent_roles_actif` (`est_actif`),
    CONSTRAINT `fk_adherent_roles_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_adherent_roles_role` 
        FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_adherent_roles_saison` 
        FOREIGN KEY (`saison_id`) REFERENCES `saisons`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 4. TABLES FINANCIÈRES
-- ============================================================================

-- Table tarifs
CREATE TABLE `tarifs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `saison_id` BIGINT UNSIGNED NOT NULL,
    `type_adhesion_id` BIGINT UNSIGNED NOT NULL,
    `montant` DECIMAL(10,2) NOT NULL,
    `description` VARCHAR(255) NULL DEFAULT NULL,
    `valide_du` DATE NOT NULL,
    `valide_jusque` DATE NULL DEFAULT NULL,
    `est_actif` TINYINT(1) DEFAULT 1,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `tarifs_unique` (`saison_id`, `type_adhesion_id`, `valide_du`),
    KEY `idx_tarifs_saison` (`saison_id`),
    KEY `idx_tarifs_actif` (`est_actif`),
    CONSTRAINT `fk_tarifs_saison` 
        FOREIGN KEY (`saison_id`) REFERENCES `saisons`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tarifs_type_adhesion` 
        FOREIGN KEY (`type_adhesion_id`) REFERENCES `types_adhesion`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table adhesions
CREATE TABLE `adhesions` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `saison_id` BIGINT UNSIGNED NOT NULL,
    `type_adhesion_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `tarif_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `montant_attendu` DECIMAL(10,2) NOT NULL,
    `montant_paye` DECIMAL(10,2) DEFAULT 0.00,
    -- Colonne calculée stockée pour solde
    `solde` DECIMAL(10,2) GENERATED ALWAYS AS (`montant_attendu` - `montant_paye`) STORED,
    `date_inscription` DATE NULL DEFAULT NULL,
    `statut` VARCHAR(32) DEFAULT 'en_attente',
    `valide_le` TIMESTAMP NULL DEFAULT NULL,
    `valide_par` BIGINT UNSIGNED NULL DEFAULT NULL,
    `numero_recu` VARCHAR(64) NULL DEFAULT NULL,
    `remarques` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `adhesions_adherent_saison_unique` (`adherent_id`, `saison_id`),
    UNIQUE KEY `adhesions_numero_recu_unique` (`numero_recu`),
    KEY `idx_adhesions_statut` (`statut`),
    KEY `idx_adhesions_saison` (`saison_id`),
    KEY `idx_adhesions_adherent` (`adherent_id`),
    CONSTRAINT `fk_adhesions_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_adhesions_saison` 
        FOREIGN KEY (`saison_id`) REFERENCES `saisons`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_adhesions_type_adhesion` 
        FOREIGN KEY (`type_adhesion_id`) REFERENCES `types_adhesion`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_adhesions_tarif` 
        FOREIGN KEY (`tarif_id`) REFERENCES `tarifs`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_adhesions_validateur` 
        FOREIGN KEY (`valide_par`) REFERENCES `utilisateurs`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table paiements
CREATE TABLE `paiements` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `adhesion_id` BIGINT UNSIGNED NOT NULL,
    `montant` DECIMAL(10,2) NOT NULL,
    `moyen_paiement` VARCHAR(32) NOT NULL,
    `reference_paiement` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `nom_banque` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `numero_cheque` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `paye_le` DATE NOT NULL,
    `depose_le` DATE NULL DEFAULT NULL,
    `statut` VARCHAR(32) DEFAULT 'en_attente',
    `remarques` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_paiements_adhesion` (`adhesion_id`),
    KEY `idx_paiements_paye_le` (`paye_le`),
    KEY `idx_paiements_statut` (`statut`),
    CONSTRAINT `fk_paiements_adhesion` 
        FOREIGN KEY (`adhesion_id`) REFERENCES `adhesions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 5. TABLES MÉDICALES
-- ============================================================================

-- Table certificats_medicaux
CREATE TABLE `certificats_medicaux` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `document_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `delivre_le` DATE NOT NULL,
    `expire_le` DATE NOT NULL,
    `types_pratique` VARCHAR(100) DEFAULT 'plongee,apnee,nage_palmes',
    `nom_medecin` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `numero_ordre_medecin` TEXT NULL DEFAULT NULL COMMENT 'Chiffré',
    `est_medecin_federal` TINYINT(1) DEFAULT 0,
    `restrictions` TEXT NULL DEFAULT NULL COMMENT 'Chiffré - TRÈS SENSIBLE',
    `questionnaire_sante_fourni` TINYINT(1) DEFAULT 0,
    `statut` VARCHAR(32) DEFAULT 'valide',
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_certificats_medicaux_adherent` (`adherent_id`),
    KEY `idx_certificats_medicaux_expire` (`expire_le`),
    KEY `idx_certificats_medicaux_statut` (`statut`),
    CONSTRAINT `fk_certificats_medicaux_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 6. TABLES CERTIFICATIONS
-- ============================================================================

-- Table certifications
CREATE TABLE `certifications` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `type_certification` VARCHAR(32) NOT NULL,
    `numero_certification` VARCHAR(64) NULL DEFAULT NULL,
    `date_delivrance` DATE NOT NULL,
    `organisme_delivrance` VARCHAR(120) DEFAULT 'FFESSM',
    `nom_delivreur` VARCHAR(120) NULL DEFAULT NULL,
    `document_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `est_courant` TINYINT(1) DEFAULT 1,
    `remarques` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_certifications_adherent` (`adherent_id`),
    KEY `idx_certifications_type` (`type_certification`),
    CONSTRAINT `fk_certifications_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 7. TABLES ENTRAINEMENTS
-- ============================================================================

-- Table seances_entrainement
CREATE TABLE `seances_entrainement` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `saison_id` BIGINT UNSIGNED NOT NULL,
    `date_seance` DATE NOT NULL,
    `heure_debut` TIME NOT NULL,
    `heure_fin` TIME NOT NULL,
    `piscine` VARCHAR(120) DEFAULT 'Centre Nautique de Vénissieux',
    `longueur_bassin` INT DEFAULT 25,
    `participants_max` INT NULL DEFAULT NULL,
    `niveau_requis` VARCHAR(50) DEFAULT 'tous',
    `statut` VARCHAR(32) DEFAULT 'planifie',
    `raison_annulation` TEXT NULL DEFAULT NULL,
    `remarques` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_seances_entrainement_date` (`date_seance`),
    KEY `idx_seances_entrainement_statut` (`statut`),
    CONSTRAINT `fk_seances_entrainement_saison` 
        FOREIGN KEY (`saison_id`) REFERENCES `saisons`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table seance_entraineurs
CREATE TABLE `seance_entraineurs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `seance_entrainement_id` BIGINT UNSIGNED NOT NULL,
    `adherent_entraineur_id` BIGINT UNSIGNED NOT NULL,
    `role_seance` VARCHAR(32) DEFAULT 'assistant',
    `confirme` TINYINT(1) DEFAULT 1,
    `raison_indisponibilite` TEXT NULL DEFAULT NULL,
    `demande_echange_avec` BIGINT UNSIGNED NULL DEFAULT NULL,
    `echange_approuve` TINYINT(1) DEFAULT 0,
    `echange_approuve_par` BIGINT UNSIGNED NULL DEFAULT NULL,
    `echange_approuve_le` TIMESTAMP NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `seance_entraineurs_unique` (`seance_entrainement_id`, `adherent_entraineur_id`),
    KEY `idx_seance_entraineurs_seance` (`seance_entrainement_id`),
    KEY `idx_seance_entraineurs_adherent` (`adherent_entraineur_id`),
    CONSTRAINT `fk_seance_entraineurs_seance` 
        FOREIGN KEY (`seance_entrainement_id`) REFERENCES `seances_entrainement`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_seance_entraineurs_adherent` 
        FOREIGN KEY (`adherent_entraineur_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_seance_entraineurs_echange` 
        FOREIGN KEY (`demande_echange_avec`) REFERENCES `adherents`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_seance_entraineurs_approbateur` 
        FOREIGN KEY (`echange_approuve_par`) REFERENCES `utilisateurs`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table programmes_entrainement
CREATE TABLE `programmes_entrainement` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(191) NOT NULL,
    `auteur_adherent_id` BIGINT UNSIGNED NOT NULL,
    `niveau` VARCHAR(50) DEFAULT 'tous',
    `duree_minutes` INT NULL DEFAULT NULL,
    `distance_totale` INT NULL DEFAULT NULL,
    `document_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `est_modele` TINYINT(1) DEFAULT 0,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_programmes_entrainement_auteur` (`auteur_adherent_id`),
    KEY `idx_programmes_entrainement_niveau` (`niveau`),
    CONSTRAINT `fk_programmes_entrainement_auteur` 
        FOREIGN KEY (`auteur_adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table seance_programmes
CREATE TABLE `seance_programmes` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `seance_entrainement_id` BIGINT UNSIGNED NOT NULL,
    `programme_entrainement_id` BIGINT UNSIGNED NOT NULL,
    `assigne_par` BIGINT UNSIGNED NULL DEFAULT NULL,
    `assigne_le` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `seance_programmes_unique` (`seance_entrainement_id`, `programme_entrainement_id`),
    CONSTRAINT `fk_seance_programmes_seance` 
        FOREIGN KEY (`seance_entrainement_id`) REFERENCES `seances_entrainement`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_seance_programmes_programme` 
        FOREIGN KEY (`programme_entrainement_id`) REFERENCES `programmes_entrainement`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_seance_programmes_assignateur` 
        FOREIGN KEY (`assigne_par`) REFERENCES `utilisateurs`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 8. TABLES SORTIES
-- ============================================================================

-- Table sorties
CREATE TABLE `sorties` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `saison_id` BIGINT UNSIGNED NOT NULL,
    `titre` VARCHAR(191) NOT NULL,
    `type_sortie` VARCHAR(32) DEFAULT 'loisir',
    `date_sortie` DATE NOT NULL,
    `heure_rendez_vous` TIME NOT NULL,
    `heure_debut` TIME NULL DEFAULT NULL,
    `lieu` VARCHAR(120) NOT NULL,
    `zone_plage` VARCHAR(120) NULL DEFAULT NULL,
    `niveau_requis` VARCHAR(50) DEFAULT 'tous',
    `participants_max` INT NULL DEFAULT NULL,
    `organisateur_adherent_id` BIGINT UNSIGNED NOT NULL,
    `consignes_securite` TEXT DEFAULT 'Bonnet de couleur et bouée de signalisation obligatoires',
    `remarques_complementaires` TEXT NULL DEFAULT NULL,
    `conditions_meteo` VARCHAR(50) NULL DEFAULT NULL,
    `temperature_eau` DECIMAL(4,1) NULL DEFAULT NULL,
    `statut` VARCHAR(32) DEFAULT 'planifie',
    `raison_annulation` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_sorties_date` (`date_sortie`),
    KEY `idx_sorties_statut` (`statut`),
    KEY `idx_sorties_organisateur` (`organisateur_adherent_id`),
    CONSTRAINT `fk_sorties_saison` 
        FOREIGN KEY (`saison_id`) REFERENCES `saisons`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sorties_organisateur` 
        FOREIGN KEY (`organisateur_adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table inscriptions_sorties
CREATE TABLE `inscriptions_sorties` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `sortie_id` BIGINT UNSIGNED NOT NULL,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `date_inscription` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `statut` VARCHAR(32) DEFAULT 'inscrit',
    `moyen_transport` VARCHAR(32) NULL DEFAULT NULL,
    `places_covoiturage_disponibles` INT NULL DEFAULT NULL,
    `nombre_accompagnants` INT DEFAULT 0,
    `remarques` TEXT NULL DEFAULT NULL,
    `annule_le` TIMESTAMP NULL DEFAULT NULL,
    `raison_annulation` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `inscriptions_sorties_unique` (`sortie_id`, `adherent_id`),
    KEY `idx_inscriptions_sorties_sortie` (`sortie_id`),
    KEY `idx_inscriptions_sorties_adherent` (`adherent_id`),
    KEY `idx_inscriptions_sorties_statut` (`statut`),
    CONSTRAINT `fk_inscriptions_sorties_sortie` 
        FOREIGN KEY (`sortie_id`) REFERENCES `sorties`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_inscriptions_sorties_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 9. TABLES COMPÉTITIONS
-- ============================================================================

-- Table competitions
CREATE TABLE `competitions` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `saison_id` BIGINT UNSIGNED NOT NULL,
    `titre` VARCHAR(191) NOT NULL,
    `organisation` VARCHAR(120) DEFAULT 'FFESSM',
    `comite_regional` VARCHAR(50) DEFAULT 'AURA',
    `date_competition` DATE NOT NULL,
    `lieu` VARCHAR(120) NOT NULL,
    `site` VARCHAR(191) NULL DEFAULT NULL,
    `date_limite_inscription` DATE NOT NULL,
    `url_inscription` VARCHAR(255) NULL DEFAULT NULL,
    `participants_max` INT NULL DEFAULT NULL,
    `statut` VARCHAR(32) DEFAULT 'a_venir',
    `est_regionale` TINYINT(1) DEFAULT 1,
    `est_nationale` TINYINT(1) DEFAULT 0,
    `necessite_hebergement` TINYINT(1) DEFAULT 0,
    `info_hebergement` TEXT NULL DEFAULT NULL,
    `remarques` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_competitions_date` (`date_competition`),
    KEY `idx_competitions_statut` (`statut`),
    KEY `idx_competitions_date_limite` (`date_limite_inscription`),
    CONSTRAINT `fk_competitions_saison` 
        FOREIGN KEY (`saison_id`) REFERENCES `saisons`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table modalites_competition
CREATE TABLE `modalites_competition` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `competition_id` BIGINT UNSIGNED NOT NULL,
    `distance` INT NOT NULL,
    `type_equipement` VARCHAR(32) NOT NULL,
    `est_relais` TINYINT(1) DEFAULT 0,
    `categorie` VARCHAR(50) NULL DEFAULT NULL,
    `participants_max` INT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_modalites_competition_competition` (`competition_id`),
    CONSTRAINT `fk_modalites_competition_competition` 
        FOREIGN KEY (`competition_id`) REFERENCES `competitions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table inscriptions_competitions
CREATE TABLE `inscriptions_competitions` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `competition_id` BIGINT UNSIGNED NOT NULL,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `modalite_competition_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `date_inscription` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `statut` VARCHAR(32) DEFAULT 'inscrit',
    `moyen_transport` VARCHAR(32) NULL DEFAULT NULL,
    `places_covoiturage_disponibles` INT NULL DEFAULT NULL,
    `besoin_hebergement` TINYINT(1) DEFAULT 0,
    `nombre_accompagnants` INT DEFAULT 0,
    `info_hebergement` TEXT NULL DEFAULT NULL,
    `temps_performance` TIME NULL DEFAULT NULL,
    `classement` INT NULL DEFAULT NULL,
    `remarques` TEXT NULL DEFAULT NULL,
    `annule_le` TIMESTAMP NULL DEFAULT NULL,
    `raison_annulation` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `inscriptions_competitions_unique` (`competition_id`, `adherent_id`),
    KEY `idx_inscriptions_competitions_competition` (`competition_id`),
    KEY `idx_inscriptions_competitions_adherent` (`adherent_id`),
    KEY `idx_inscriptions_competitions_statut` (`statut`),
    CONSTRAINT `fk_inscriptions_competitions_competition` 
        FOREIGN KEY (`competition_id`) REFERENCES `competitions`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_inscriptions_competitions_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_inscriptions_competitions_modalite` 
        FOREIGN KEY (`modalite_competition_id`) REFERENCES `modalites_competition`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 10. TABLES MATÉRIEL
-- ============================================================================

-- Table types_materiel
CREATE TABLE `types_materiel` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(80) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `a_taille` TINYINT(1) DEFAULT 0,
    `a_marque` TINYINT(1) DEFAULT 1,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `types_materiel_nom_unique` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table inventaire_materiel
CREATE TABLE `inventaire_materiel` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `type_materiel_id` BIGINT UNSIGNED NOT NULL,
    `code_materiel` VARCHAR(64) NOT NULL,
    `marque` VARCHAR(80) NULL DEFAULT NULL,
    `taille_ou_pointure` VARCHAR(20) NULL DEFAULT NULL,
    `date_achat` DATE NULL DEFAULT NULL,
    `prix_achat` DECIMAL(10,2) NULL DEFAULT NULL,
    `etat` VARCHAR(32) DEFAULT 'bon',
    `statut` VARCHAR(32) DEFAULT 'disponible',
    `remarques` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY `inventaire_materiel_code_unique` (`code_materiel`),
    KEY `idx_inventaire_materiel_type` (`type_materiel_id`),
    KEY `idx_inventaire_materiel_statut` (`statut`),
    KEY `idx_inventaire_materiel_code` (`code_materiel`),
    CONSTRAINT `fk_inventaire_materiel_type` 
        FOREIGN KEY (`type_materiel_id`) REFERENCES `types_materiel`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table prets_materiel
CREATE TABLE `prets_materiel` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `materiel_id` BIGINT UNSIGNED NOT NULL,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `saison_id` BIGINT UNSIGNED NOT NULL,
    `prete_le` DATE NOT NULL,
    `date_retour_prevue` DATE NULL DEFAULT NULL,
    `rendu_le` DATE NULL DEFAULT NULL,
    `etat_au_retour` VARCHAR(32) NULL DEFAULT NULL,
    `gere_par` BIGINT UNSIGNED NULL DEFAULT NULL,
    `remarques` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_prets_materiel_materiel` (`materiel_id`),
    KEY `idx_prets_materiel_adherent` (`adherent_id`),
    KEY `idx_prets_materiel_rendu` (`rendu_le`),
    CONSTRAINT `fk_prets_materiel_materiel` 
        FOREIGN KEY (`materiel_id`) REFERENCES `inventaire_materiel`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_prets_materiel_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_prets_materiel_saison` 
        FOREIGN KEY (`saison_id`) REFERENCES `saisons`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_prets_materiel_gestionnaire` 
        FOREIGN KEY (`gere_par`) REFERENCES `utilisateurs`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 11. TABLES DOCUMENTS ET RGPD
-- ============================================================================

-- Table documents
CREATE TABLE `documents` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `type_documentable` VARCHAR(120) NOT NULL,
    `id_documentable` BIGINT UNSIGNED NOT NULL,
    `type_document` VARCHAR(64) NOT NULL,
    `nom_fichier_original` VARCHAR(255) NOT NULL,
    `nom_fichier_stocke` VARCHAR(255) NOT NULL,
    `chemin_fichier` VARCHAR(255) NOT NULL,
    `hash_fichier` VARCHAR(64) NOT NULL,
    `type_mime` VARCHAR(100) NOT NULL,
    `taille_fichier` BIGINT UNSIGNED NOT NULL,
    `disque_stockage` VARCHAR(20) DEFAULT 'local',
    `version` INT DEFAULT 1,
    `est_archive` TINYINT(1) DEFAULT 0,
    `televerse_par` BIGINT UNSIGNED NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_documents_type` (`type_document`),
    KEY `idx_documents_polymorphic` (`type_documentable`, `id_documentable`),
    KEY `idx_documents_cree` (`cree_le`),
    CONSTRAINT `fk_documents_televerseur` 
        FOREIGN KEY (`televerse_par`) REFERENCES `utilisateurs`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ajout des contraintes de clés étrangères pour documents
ALTER TABLE `certificats_medicaux` 
ADD CONSTRAINT `fk_certificat_medical_document` 
FOREIGN KEY (`document_id`) REFERENCES `documents`(`id`) ON DELETE SET NULL;

ALTER TABLE `certifications` 
ADD CONSTRAINT `fk_certification_document` 
FOREIGN KEY (`document_id`) REFERENCES `documents`(`id`) ON DELETE SET NULL;

ALTER TABLE `programmes_entrainement` 
ADD CONSTRAINT `fk_programme_entrainement_document` 
FOREIGN KEY (`document_id`) REFERENCES `documents`(`id`) ON DELETE SET NULL;

-- Table consentements
CREATE TABLE `consentements` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `adherent_id` BIGINT UNSIGNED NOT NULL,
    `type_consentement` VARCHAR(80) NOT NULL,
    `accorde` TINYINT(1) DEFAULT 0,
    `accorde_le` TIMESTAMP NULL DEFAULT NULL,
    `revoque_le` TIMESTAMP NULL DEFAULT NULL,
    `adresse_ip` VARCHAR(45) NULL DEFAULT NULL,
    `agent_utilisateur` TEXT NULL DEFAULT NULL,
    `cree_le` TIMESTAMP NULL DEFAULT NULL,
    `modifie_le` TIMESTAMP NULL DEFAULT NULL,
    KEY `idx_consentements_adherent` (`adherent_id`),
    KEY `idx_consentements_type` (`type_consentement`),
    CONSTRAINT `fk_consentements_adherent` 
        FOREIGN KEY (`adherent_id`) REFERENCES `adherents`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 12. VUE UTILITAIRE
-- ============================================================================

-- Supprimer la vue si elle existe déjà
DROP VIEW IF EXISTS `v_statut_adhesions`;

-- Créer la vue
CREATE VIEW `v_statut_adhesions` AS
SELECT 
    a.`id` as `adherent_id`,
    a.`prenom`,
    a.`nom`,
    ad.`id` as `adhesion_id`,
    s.`nom` as `saison`,
    ad.`statut` as `statut_adhesion`,
    ad.`montant_attendu`,
    ad.`montant_paye`,
    ad.`solde`,
    CASE 
        WHEN ad.`solde` <= 0 THEN 'Payé'
        WHEN ad.`solde` > 0 AND ad.`montant_paye` > 0 THEN 'Partiel'
        ELSE 'Non payé'
    END as `statut_paiement`,
    cm.`statut` as `statut_certificat_medical`,
    cm.`expire_le` as `expiration_certificat_medical`,
    CASE
        WHEN cm.`expire_le` < CURRENT_DATE() THEN 'Expiré'
        WHEN cm.`expire_le` < DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) THEN 'À renouveler'
        ELSE 'Valide'
    END as `alerte_medicale`
FROM `adherents` a
LEFT JOIN `adhesions` ad ON a.`id` = ad.`adherent_id`
LEFT JOIN `saisons` s ON ad.`saison_id` = s.`id`
LEFT JOIN `certificats_medicaux` cm ON a.`id` = cm.`adherent_id`
WHERE a.`statut` = 'actif';

SET FOREIGN_KEY_CHECKS = 1;
