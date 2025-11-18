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
        Schema::create('programmes_entrainement', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 191);
            $table->foreignId('auteur_adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->string('niveau', 50)->default('tous');
            $table->integer('duree_minutes')->nullable();
            $table->integer('distance_totale')->nullable();
            $table->foreignId('document_id')->nullable();  // Foreign key ajoutée plus tard
            $table->text('description')->nullable();
            $table->boolean('est_modele')->default(false);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('auteur_adherent_id', 'idx_programmes_entrainement_auteur');
            $table->index('niveau', 'idx_programmes_entrainement_niveau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programmes_entrainement');
    }
};
