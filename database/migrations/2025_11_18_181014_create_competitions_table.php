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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->string('titre', 191);
            $table->string('organisation', 120)->default('FFESSM');
            $table->string('comite_regional', 50)->default('AURA');
            $table->date('date_competition');
            $table->string('lieu', 120);
            $table->string('site', 191)->nullable();
            $table->date('date_limite_inscription');
            $table->string('url_inscription', 255)->nullable();
            $table->integer('participants_max')->nullable();
            $table->string('statut', 32)->default('a_venir');
            $table->boolean('est_regionale')->default(true);
            $table->boolean('est_nationale')->default(false);
            $table->boolean('necessite_hebergement')->default(false);
            $table->text('info_hebergement')->nullable();
            $table->text('remarques')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('date_competition', 'idx_competitions_date');
            $table->index('statut', 'idx_competitions_statut');
            $table->index('date_limite_inscription', 'idx_competitions_date_limite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
