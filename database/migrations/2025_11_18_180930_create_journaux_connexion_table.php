<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journaux_connexion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->string('email', 191);
            $table->string('adresse_ip', 45);
            $table->text('agent_utilisateur');
            $table->boolean('connexion_reussie')->default(true);
            $table->timestamp('deconnexion_le')->nullable();
            $table->timestamp('cree_le')->nullable();

            $table->index('utilisateur_id', 'idx_journaux_connexion_utilisateur');
            $table->index('cree_le', 'idx_journaux_connexion_cree');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journaux_connexion');
    }
};
