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
        // Ajouter les contraintes de clés étrangères pour les colonnes document_id
        Schema::table('certificats_medicaux', function (Blueprint $table) {
            $table->foreign('document_id', 'fk_certificat_medical_document')
                  ->references('id')->on('documents')
                  ->nullOnDelete();
        });

        Schema::table('certifications', function (Blueprint $table) {
            $table->foreign('document_id', 'fk_certification_document')
                  ->references('id')->on('documents')
                  ->nullOnDelete();
        });

        Schema::table('programmes_entrainement', function (Blueprint $table) {
            $table->foreign('document_id', 'fk_programme_entrainement_document')
                  ->references('id')->on('documents')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificats_medicaux', function (Blueprint $table) {
            $table->dropForeign('fk_certificat_medical_document');
        });

        Schema::table('certifications', function (Blueprint $table) {
            $table->dropForeign('fk_certification_document');
        });

        Schema::table('programmes_entrainement', function (Blueprint $table) {
            $table->dropForeign('fk_programme_entrainement_document');
        });
    }
};
