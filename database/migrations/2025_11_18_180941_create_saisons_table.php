<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saisons', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 80)->unique();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('est_courante')->default(false);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('est_courante', 'idx_saisons_courante');
        });

        // Add CHECK constraint using raw SQL
        DB::statement('ALTER TABLE `saisons` ADD CONSTRAINT `chk_dates_saison` CHECK (`date_fin` > `date_debut`)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saisons');
    }
};
