<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Ajoute des champs de recherche hashés (pseudonymisés) pour permettre
     * la recherche efficace tout en gardant les données sensibles chiffrées.
     *
     * Approche : Hash unidirectionnel (non réversible) pour la recherche
     */
    public function up(): void
    {
        Schema::table('adherents', function (Blueprint $table) {
            // Champs de recherche hashés pour recherche rapide
            $table->string('nom_recherche', 255)->nullable()->after('nom')
                ->comment('Hash du nom pour recherche (SHA-256)');

            $table->string('prenom_recherche', 255)->nullable()->after('prenom')
                ->comment('Hash du prénom pour recherche (SHA-256)');

            $table->string('nom_complet_recherche', 255)->nullable()->after('prenom_recherche')
                ->comment('Hash nom+prénom pour recherche exacte (SHA-256)');

            // Index pour performance
            $table->index('nom_recherche', 'idx_adherents_nom_recherche');
            $table->index('prenom_recherche', 'idx_adherents_prenom_recherche');
            $table->index('nom_complet_recherche', 'idx_adherents_nom_complet_recherche');
        });

        Schema::table('representants_legaux', function (Blueprint $table) {
            $table->string('nom_recherche', 255)->nullable()->after('nom')
                ->comment('Hash du nom pour recherche (SHA-256)');

            $table->string('prenom_recherche', 255)->nullable()->after('prenom')
                ->comment('Hash du prénom pour recherche (SHA-256)');

            $table->string('nom_complet_recherche', 255)->nullable()->after('prenom_recherche')
                ->comment('Hash nom+prénom pour recherche exacte (SHA-256)');

            $table->index('nom_recherche', 'idx_representants_nom_recherche');
            $table->index('prenom_recherche', 'idx_representants_prenom_recherche');
            $table->index('nom_complet_recherche', 'idx_representants_nom_complet_recherche');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adherents', function (Blueprint $table) {
            $table->dropIndex('idx_adherents_nom_recherche');
            $table->dropIndex('idx_adherents_prenom_recherche');
            $table->dropIndex('idx_adherents_nom_complet_recherche');
            $table->dropColumn(['nom_recherche', 'prenom_recherche', 'nom_complet_recherche']);
        });

        Schema::table('representants_legaux', function (Blueprint $table) {
            $table->dropIndex('idx_representants_nom_recherche');
            $table->dropIndex('idx_representants_prenom_recherche');
            $table->dropIndex('idx_representants_nom_complet_recherche');
            $table->dropColumn(['nom_recherche', 'prenom_recherche', 'nom_complet_recherche']);
        });
    }
};
