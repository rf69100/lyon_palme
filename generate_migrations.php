<?php
/**
 * Script pour générer toutes les migrations à partir du schéma SQL
 * Exécuter: php generate_migrations.php
 */

$migrationsPath = __DIR__ . '/database/migrations/';

// Définir toutes les migrations
$migrations = [
    [
        'file' => '2025_11_18_180925_create_jetons_reinitialisation_mdp_table.php',
        'content' => <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jetons_reinitialisation_mdp', function (Blueprint $table) {
            $table->string('email', 191)->primary();
            $table->string('jeton', 255);
            $table->timestamp('cree_le')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jetons_reinitialisation_mdp');
    }
};
PHP
    ],
    [
        'file' => '2025_11_18_180930_create_journaux_connexion_table.php',
        'content' => <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journaux_connexion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->nullable()->constrained('utilisateurs')->nullOnDelete();
            $table->string('email', 191);
            $table->string('adresse_ip', 45);
            $table->text('agent_utilisateur');
            $table->boolean('connexion_reussie')->default(true);
            $table->timestamp('deconnexion_le')->nullable();
            $table->timestamp('cree_le')->nullable();

            $table->index('utilisateur_id', 'idx_journaux_connexion_utilisateur');
            $table->index('cree_le', 'idx_journaux_connexion_cree');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journaux_connexion');
    }
};
PHP
    ],
];

// Écrire les fichiers
foreach ($migrations as $migration) {
    $filePath = $migrationsPath . $migration['file'];
    file_put_contents($filePath, $migration['content']);
    echo "✓ Créé: {$migration['file']}\n";
}

echo "\n✅ Migrations générées avec succès!\n";
