<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Supprimer la vue si elle existe déjà
        DB::statement('DROP VIEW IF EXISTS `v_statut_adhesions`');

        // Créer la vue
        DB::statement("
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
            WHERE a.`statut` = 'actif'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `v_statut_adhesions`');
    }
};
