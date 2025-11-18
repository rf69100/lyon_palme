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
        Schema::create('adhesions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->foreignId('type_adhesion_id')->nullable()->constrained('types_adhesion')->nullOnDelete();
            $table->foreignId('tarif_id')->nullable()->constrained('tarifs')->nullOnDelete();
            $table->decimal('montant_attendu', 10, 2);
            $table->decimal('montant_paye', 10, 2)->default(0.00);
            // Note: colonne calculée 'solde' sera ajoutée via raw SQL après la création de la table
            $table->date('date_inscription')->nullable();
            $table->string('statut', 32)->default('en_attente');
            $table->timestamp('valide_le')->nullable();
            $table->foreignId('valide_par')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->string('numero_recu', 64)->nullable()->unique();
            $table->text('remarques')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Unique constraints
            $table->unique(['adherent_id', 'saison_id'], 'adhesions_adherent_saison_unique');

            // Index
            $table->index('statut', 'idx_adhesions_statut');
            $table->index('saison_id', 'idx_adhesions_saison');
            $table->index('adherent_id', 'idx_adhesions_adherent');
        });

        // Ajouter la colonne calculée GENERATED ALWAYS AS
        DB::statement('ALTER TABLE `adhesions` ADD COLUMN `solde` DECIMAL(10,2) GENERATED ALWAYS AS (`montant_attendu` - `montant_paye`) STORED AFTER `montant_paye`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adhesions');
    }
};
