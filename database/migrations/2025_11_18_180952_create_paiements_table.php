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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adhesion_id')->constrained('adhesions')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->string('moyen_paiement', 32);
            $table->text('reference_paiement')->nullable()->comment('Chiffré');
            $table->text('nom_banque')->nullable()->comment('Chiffré');
            $table->text('numero_cheque')->nullable()->comment('Chiffré');
            $table->date('paye_le');
            $table->date('depose_le')->nullable();
            $table->string('statut', 32)->default('en_attente');
            $table->text('remarques')->nullable();
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();

            // Index
            $table->index('adhesion_id', 'idx_paiements_adhesion');
            $table->index('paye_le', 'idx_paiements_paye_le');
            $table->index('statut', 'idx_paiements_statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
