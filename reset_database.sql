-- Script pour réinitialiser complètement la base de données
-- Exécuter: mysql -u lyonpalme_user -p lyonpalme < reset_database.sql

SET FOREIGN_KEY_CHECKS = 0;

-- Supprimer toutes les tables
DROP TABLE IF EXISTS consentements;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS prets_materiel;
DROP TABLE IF EXISTS inventaire_materiel;
DROP TABLE IF EXISTS types_materiel;
DROP TABLE IF EXISTS inscriptions_competitions;
DROP TABLE IF EXISTS modalites_competition;
DROP TABLE IF EXISTS competitions;
DROP TABLE IF EXISTS inscriptions_sorties;
DROP TABLE IF EXISTS sorties;
DROP TABLE IF EXISTS seance_programmes;
DROP TABLE IF EXISTS programmes_entrainement;
DROP TABLE IF EXISTS seance_entraineurs;
DROP TABLE IF EXISTS seances_entrainement;
DROP TABLE IF EXISTS certifications;
DROP TABLE IF EXISTS certificats_medicaux;
DROP TABLE IF EXISTS paiements;
DROP TABLE IF EXISTS adhesions;
DROP TABLE IF EXISTS tarifs;
DROP TABLE IF EXISTS adherent_roles;
DROP TABLE IF EXISTS representants_legaux;
DROP TABLE IF EXISTS adherents;
DROP TABLE IF EXISTS types_adhesion;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS saisons;
DROP TABLE IF EXISTS journaux_connexion;
DROP TABLE IF EXISTS jetons_reinitialisation_mdp;
DROP TABLE IF EXISTS utilisateurs;
DROP TABLE IF EXISTS migrations;
DROP VIEW IF EXISTS v_statut_adhesions;

SET FOREIGN_KEY_CHECKS = 1;
