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
        Schema::create('seances_entrainement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->date('date_seance');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('piscine', 120)->default('Centre Nautique de Vénissieux');
            $table->integer('longueur_bassin')->default(25);
            $table->integer('participants_max')->nullable();
            $table->string('niveau_requis', 50)->default('tous');
            $table->string('statut', 32)->default('planifie');
            $table->text('raison_annulation')->nullable();
            $table->text('remarques')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('date_seance', 'idx_seances_entrainement_date');
            $table->index('statut', 'idx_seances_entrainement_statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances_entrainement');
    }
};
