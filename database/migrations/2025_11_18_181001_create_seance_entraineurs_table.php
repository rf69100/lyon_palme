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
        Schema::create('seance_entraineurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seance_entrainement_id')->constrained('seances_entrainement')->onDelete('cascade');
            $table->foreignId('adherent_entraineur_id')->constrained('adherents')->onDelete('cascade');
            $table->string('role_seance', 32)->default('assistant');
            $table->boolean('confirme')->default(true);
            $table->text('raison_indisponibilite')->nullable();
            $table->foreignId('demande_echange_avec')->nullable()->constrained('adherents')->nullOnDelete();
            $table->boolean('echange_approuve')->default(false);
            $table->foreignId('echange_approuve_par')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->timestamp('echange_approuve_le')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Unique constraint
            $table->unique(['seance_entrainement_id', 'adherent_entraineur_id'], 'seance_entraineurs_unique');

            // Index
            $table->index('seance_entrainement_id', 'idx_seance_entraineurs_seance');
            $table->index('adherent_entraineur_id', 'idx_seance_entraineurs_adherent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seance_entraineurs');
    }
};
