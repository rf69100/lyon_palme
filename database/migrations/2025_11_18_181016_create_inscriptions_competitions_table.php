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
        Schema::create('inscriptions_competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained('competitions')->onDelete('cascade');
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->foreignId('modalite_competition_id')->nullable()->constrained('modalites_competition')->nullOnDelete();
            $table->timestamp('date_inscription')->useCurrent();
            $table->string('statut', 32)->default('inscrit');
            $table->string('moyen_transport', 32)->nullable();
            $table->integer('places_covoiturage_disponibles')->nullable();
            $table->boolean('besoin_hebergement')->default(false);
            $table->integer('nombre_accompagnants')->default(0);
            $table->text('info_hebergement')->nullable();
            $table->time('temps_performance')->nullable();
            $table->integer('classement')->nullable();
            $table->text('remarques')->nullable();
            $table->timestamp('annule_le')->nullable();
            $table->text('raison_annulation')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Unique constraint
            $table->unique(['competition_id', 'adherent_id'], 'inscriptions_competitions_unique');

            // Index
            $table->index('competition_id', 'idx_inscriptions_competitions_competition');
            $table->index('adherent_id', 'idx_inscriptions_competitions_adherent');
            $table->index('statut', 'idx_inscriptions_competitions_statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions_competitions');
    }
};
