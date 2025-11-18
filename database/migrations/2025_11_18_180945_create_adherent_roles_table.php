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
        Schema::create('adherent_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('saison_id')->nullable()->constrained('saisons')->nullOnDelete();
            $table->date('attribue_le')->nullable();
            $table->date('revoque_le')->nullable();
            $table->boolean('est_actif')->default(true);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Unique constraint
            $table->unique(['adherent_id', 'role_id', 'saison_id'], 'adherent_roles_unique');

            // Index
            $table->index('adherent_id', 'idx_adherent_roles_adherent');
            $table->index('est_actif', 'idx_adherent_roles_actif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherent_roles');
    }
};
