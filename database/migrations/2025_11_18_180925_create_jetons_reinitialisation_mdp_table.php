<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jetons_reinitialisation_mdp', function (Blueprint $table) {
            $table->string('email', 191)->primary();
            $table->string('jeton', 255);
            $table->timestamp('cree_le')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jetons_reinitialisation_mdp');
    }
};
