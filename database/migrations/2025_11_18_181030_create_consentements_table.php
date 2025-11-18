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
        Schema::create('consentements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->string('type_consentement', 80);
            $table->boolean('accorde')->default(false);
            $table->timestamp('accorde_le')->nullable();
            $table->timestamp('revoque_le')->nullable();
            $table->string('adresse_ip', 45)->nullable();
            $table->text('agent_utilisateur')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('adherent_id', 'idx_consentements_adherent');
            $table->index('type_consentement', 'idx_consentements_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consentements');
    }
};
