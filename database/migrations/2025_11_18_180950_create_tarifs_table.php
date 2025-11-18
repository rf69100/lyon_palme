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
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->foreignId('type_adhesion_id')->constrained('types_adhesion')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->string('description', 255)->nullable();
            $table->date('valide_du');
            $table->date('valide_jusque')->nullable();
            $table->boolean('est_actif')->default(true);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Unique constraint
            $table->unique(['saison_id', 'type_adhesion_id', 'valide_du'], 'tarifs_unique');

            // Index
            $table->index('saison_id', 'idx_tarifs_saison');
            $table->index('est_actif', 'idx_tarifs_actif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifs');
    }
};
