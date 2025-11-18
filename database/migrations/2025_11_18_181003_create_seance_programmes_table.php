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
        Schema::create('seance_programmes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seance_entrainement_id')->constrained('seances_entrainement')->onDelete('cascade');
            $table->foreignId('programme_entrainement_id')->constrained('programmes_entrainement')->onDelete('cascade');
            $table->foreignId('assigne_par')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->timestamp('assigne_le')->useCurrent();

            // Unique constraint
            $table->unique(['seance_entrainement_id', 'programme_entrainement_id'], 'seance_programmes_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seance_programmes');
    }
};
