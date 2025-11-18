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
        Schema::create('inventaire_materiel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_materiel_id')->constrained('types_materiel')->onDelete('cascade');
            $table->string('code_materiel', 64)->unique();
            $table->string('marque', 80)->nullable();
            $table->string('taille_ou_pointure', 20)->nullable();
            $table->date('date_achat')->nullable();
            $table->decimal('prix_achat', 10, 2)->nullable();
            $table->string('etat', 32)->default('bon');
            $table->string('statut', 32)->default('disponible');
            $table->text('remarques')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('type_materiel_id', 'idx_inventaire_materiel_type');
            $table->index('statut', 'idx_inventaire_materiel_statut');
            $table->index('code_materiel', 'idx_inventaire_materiel_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaire_materiel');
    }
};
