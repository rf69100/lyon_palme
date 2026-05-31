<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Préférences RGPD du nageur : apparition (ou non) dans le trombinoscope
     * et l'annuaire. Opt-in : désactivé par défaut.
     */
    public function up(): void
    {
        Schema::table('adherents', function (Blueprint $table) {
            $table->boolean('afficher_trombinoscope')->default(false)->after('chemin_photo');
            $table->boolean('afficher_annuaire')->default(false)->after('afficher_trombinoscope');
        });
    }

    public function down(): void
    {
        Schema::table('adherents', function (Blueprint $table) {
            $table->dropColumn(['afficher_trombinoscope', 'afficher_annuaire']);
        });
    }
};
