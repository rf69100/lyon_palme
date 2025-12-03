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
        Schema::table('utilisateurs', function (Blueprint $table) {
            // Track password last changed date (for expiration policy - 90 days)
            $table->timestamp('mot_de_passe_change_le')->nullable()->after('mot_de_passe');

            // Flag if password is expired and must be changed
            $table->boolean('mot_de_passe_expire')->default(false)->after('mot_de_passe_change_le');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->dropColumn(['mot_de_passe_change_le', 'mot_de_passe_expire']);
        });
    }
};
