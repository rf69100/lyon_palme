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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('type_documentable', 120);
            $table->unsignedBigInteger('id_documentable');
            $table->string('type_document', 64);
            $table->string('nom_fichier_original', 255);
            $table->string('nom_fichier_stocke', 255);
            $table->string('chemin_fichier', 255);
            $table->string('hash_fichier', 64);
            $table->string('type_mime', 100);
            $table->unsignedBigInteger('taille_fichier');
            $table->string('disque_stockage', 20)->default('local');
            $table->integer('version')->default(1);
            $table->boolean('est_archive')->default(false);
            $table->foreignId('televerse_par')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('type_document', 'idx_documents_type');
            $table->index(['type_documentable', 'id_documentable'], 'idx_documents_polymorphic');
            $table->index('cree_le', 'idx_documents_cree');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
