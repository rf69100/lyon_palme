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
        Schema::create('certificats_medicaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->foreignId('document_id')->nullable();  // Foreign key ajoutée plus tard
            $table->date('delivre_le');
            $table->date('expire_le');
            $table->string('types_pratique', 100)->default('plongee,apnee,nage_palmes');
            $table->text('nom_medecin')->nullable()->comment('Chiffré');
            $table->text('numero_ordre_medecin')->nullable()->comment('Chiffré');
            $table->boolean('est_medecin_federal')->default(false);
            $table->text('restrictions')->nullable()->comment('Chiffré - TRÈS SENSIBLE');
            $table->boolean('questionnaire_sante_fourni')->default(false);
            $table->string('statut', 32)->default('valide');
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('adherent_id', 'idx_certificats_medicaux_adherent');
            $table->index('expire_le', 'idx_certificats_medicaux_expire');
            $table->index('statut', 'idx_certificats_medicaux_statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificats_medicaux');
    }
};
