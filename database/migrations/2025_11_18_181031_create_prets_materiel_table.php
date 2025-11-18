<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prets_materiel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materiel_id')->constrained('inventaire_materiel')->onDelete('cascade');
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->date('prete_le');
            $table->date('date_retour_prevue')->nullable();
            $table->date('rendu_le')->nullable();
            $table->string('etat_au_retour', 32)->nullable();
            $table->foreignId('gere_par')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->text('remarques')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('materiel_id', 'idx_prets_materiel_materiel');
            $table->index('adherent_id', 'idx_prets_materiel_adherent');
            $table->index('rendu_le', 'idx_prets_materiel_rendu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prets_materiel');
    }
};
