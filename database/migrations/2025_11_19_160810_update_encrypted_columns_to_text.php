<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Mise à jour des colonnes qui stockent des données chiffrées vers le type TEXT
     * car les données chiffrées par Laravel (AES-256-CBC) sont beaucoup plus longues
     * que les données en clair.
     *
     * Exemple: "Jean" (4 caractères) devient ~200 caractères une fois chiffré.
     */
    public function up(): void
    {
        // Table adherents - Données personnelles chiffrées (RGPD Art. 4)
        Schema::table('adherents', function (Blueprint $table) {
            // Supprimer les index qui utilisent les colonnes à modifier
            $table->dropIndex('idx_adherents_nom');
            $table->dropIndex('idx_adherents_email');
        });

        Schema::table('adherents', function (Blueprint $table) {
            // Données directement identifiantes
            $table->text('prenom')->change()->comment('Chiffré - RGPD Art. 4');
            $table->text('nom')->change()->comment('Chiffré - RGPD Art. 4');
            $table->text('email')->nullable()->change()->comment('Chiffré - RGPD Art. 4');

            // Données indirectement identifiantes
            $table->text('date_naissance')->change()->comment('Chiffré - RGPD Art. 4');
        });

        // Table representants_legaux - Données personnelles chiffrées
        Schema::table('representants_legaux', function (Blueprint $table) {
            // Données directement identifiantes
            $table->text('prenom')->change()->comment('Chiffré - RGPD Art. 4');
            $table->text('nom')->change()->comment('Chiffré - RGPD Art. 4');
            $table->text('email')->nullable()->change()->comment('Chiffré - RGPD Art. 4');
        });

        // Table certificats_medicaux - Données de santé (RGPD Art. 9)
        Schema::table('certificats_medicaux', function (Blueprint $table) {
            $table->text('nom_medecin')->nullable()->change()->comment('Chiffré - RGPD Art. 9');
            $table->text('numero_ordre_medecin')->nullable()->change()->comment('Chiffré - RGPD Art. 9');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retour aux types originaux (attention: perte possible de données si chiffrées)
        Schema::table('adherents', function (Blueprint $table) {
            $table->string('prenom', 80)->change();
            $table->string('nom', 80)->change();
            $table->string('email', 191)->nullable()->change();
            $table->date('date_naissance')->change();
        });

        // Recréer les index
        Schema::table('adherents', function (Blueprint $table) {
            $table->index(['nom', 'prenom'], 'idx_adherents_nom');
            $table->index('email', 'idx_adherents_email');
        });

        Schema::table('representants_legaux', function (Blueprint $table) {
            $table->string('prenom', 80)->change();
            $table->string('nom', 80)->change();
            $table->string('email', 191)->nullable()->change();
        });

        Schema::table('certificats_medicaux', function (Blueprint $table) {
            $table->string('nom_medecin', 191)->nullable()->change();
            $table->string('numero_ordre_medecin', 100)->nullable()->change();
        });
    }
};
