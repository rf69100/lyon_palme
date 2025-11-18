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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 191);
            $table->string('email', 191)->unique();
            $table->timestamp('email_verifie_le')->nullable();
            $table->string('mot_de_passe', 255)->comment('Hashé avec bcrypt');
            $table->string('jeton_souvenir', 100)->nullable();
            $table->boolean('doit_changer_mdp')->default(true);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            $table->index('email', 'idx_utilisateurs_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
