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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->string('type_certification', 32);
            $table->string('numero_certification', 64)->nullable();
            $table->date('date_delivrance');
            $table->string('organisme_delivrance', 120)->default('FFESSM');
            $table->string('nom_delivreur', 120)->nullable();
            $table->foreignId('document_id')->nullable();  // Foreign key ajoutée plus tard
            $table->boolean('est_courant')->default(true);
            $table->text('remarques')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('adherent_id', 'idx_certifications_adherent');
            $table->index('type_certification', 'idx_certifications_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
