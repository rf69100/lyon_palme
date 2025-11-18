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
        Schema::create('representants_legaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_mineur_id')->constrained('adherents')->onDelete('cascade');
            $table->string('civilite', 10);
            $table->string('prenom', 80);
            $table->string('nom', 80);
            $table->string('lien_parente', 50);
            $table->string('email', 191)->nullable();
            $table->text('telephone')->nullable()->comment('Chiffré');
            $table->text('mobile')->nullable()->comment('Chiffré');
            $table->text('numero_rue')->nullable()->comment('Chiffré');
            $table->text('rue')->nullable()->comment('Chiffré');
            $table->text('complement_adresse')->nullable()->comment('Chiffré');
            $table->text('code_postal')->nullable()->comment('Chiffré');
            $table->text('ville')->nullable()->comment('Chiffré');
            $table->string('pays', 80)->default('France');
            $table->boolean('est_principal')->default(false);
            $table->boolean('peut_recuperer')->default(true);
            $table->boolean('autorise_sortie')->default(true);
            $table->boolean('autorise_transport')->default(true);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('adherent_mineur_id', 'idx_representants_legaux_mineur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representants_legaux');
    }
};
