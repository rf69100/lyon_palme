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
        Schema::create('sorties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->string('titre', 191);
            $table->string('type_sortie', 32)->default('loisir');
            $table->date('date_sortie');
            $table->time('heure_rendez_vous');
            $table->time('heure_debut')->nullable();
            $table->string('lieu', 120);
            $table->string('zone_plage', 120)->nullable();
            $table->string('niveau_requis', 50)->default('tous');
            $table->integer('participants_max')->nullable();
            $table->foreignId('organisateur_adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->text('consignes_securite')->default('Bonnet de couleur et bouée de signalisation obligatoires');
            $table->text('remarques_complementaires')->nullable();
            $table->string('conditions_meteo', 50)->nullable();
            $table->decimal('temperature_eau', 4, 1)->nullable();
            $table->string('statut', 32)->default('planifie');
            $table->text('raison_annulation')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('date_sortie', 'idx_sorties_date');
            $table->index('statut', 'idx_sorties_statut');
            $table->index('organisateur_adherent_id', 'idx_sorties_organisateur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorties');
    }
};
