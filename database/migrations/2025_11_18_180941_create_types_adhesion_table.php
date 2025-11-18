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
        Schema::create('types_adhesion', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 80);
            $table->text('description')->nullable();
            $table->boolean('necessite_justificatif')->default(false);
            $table->boolean('est_actif')->default(true);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types_adhesion');
    }
};
