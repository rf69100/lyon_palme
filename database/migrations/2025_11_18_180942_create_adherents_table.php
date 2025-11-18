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
        Schema::create('adherents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->string('civilite', 10);
            $table->string('prenom', 80);
            $table->string('nom', 80);
            $table->date('date_naissance');
            $table->string('email', 191)->nullable();
            $table->text('telephone')->nullable()->comment('Chiffré');
            $table->text('mobile')->nullable()->comment('Chiffré');
            $table->text('numero_rue')->nullable()->comment('Chiffré');
            $table->text('rue')->nullable()->comment('Chiffré');
            $table->text('complement_adresse')->nullable()->comment('Chiffré');
            $table->text('code_postal')->nullable()->comment('Chiffré');
            $table->text('ville')->nullable()->comment('Chiffré');
            $table->string('pays', 80)->default('France');
            $table->string('chemin_photo', 255)->nullable();
            $table->text('contact_urgence_nom')->nullable()->comment('Chiffré');
            $table->text('contact_urgence_telephone')->nullable()->comment('Chiffré');
            $table->text('contact_urgence_lien')->nullable()->comment('Chiffré');
            $table->string('statut', 32)->default('actif');
            $table->timestamp('archive_le')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();
            $table->boolean('est_mineur')->nullable();

            // Index
            $table->index('statut', 'idx_adherents_statut');
            $table->index('email', 'idx_adherents_email');
            $table->index('est_mineur', 'idx_adherents_mineur');
            $table->index(['nom', 'prenom'], 'idx_adherents_nom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherents');
    }
};
