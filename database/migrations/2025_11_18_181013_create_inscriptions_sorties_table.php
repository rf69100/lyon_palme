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
        Schema::create('inscriptions_sorties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sortie_id')->constrained('sorties')->onDelete('cascade');
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->timestamp('date_inscription')->useCurrent();
            $table->string('statut', 32)->default('inscrit');
            $table->string('moyen_transport', 32)->nullable();
            $table->integer('places_covoiturage_disponibles')->nullable();
            $table->integer('nombre_accompagnants')->default(0);
            $table->text('remarques')->nullable();
            $table->timestamp('annule_le')->nullable();
            $table->text('raison_annulation')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Unique constraint
            $table->unique(['sortie_id', 'adherent_id'], 'inscriptions_sorties_unique');

            // Index
            $table->index('sortie_id', 'idx_inscriptions_sorties_sortie');
            $table->index('adherent_id', 'idx_inscriptions_sorties_adherent');
            $table->index('statut', 'idx_inscriptions_sorties_statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions_sorties');
    }
};
