<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Démarrage du seeding de la base de données Lyon Palme...');
        $this->command->newLine();

        $this->call([
            // 1. Données de référence
            RoleSeeder::class,
            TypeAdhesionSeeder::class,
            TypeMaterielSeeder::class,
            SaisonSeeder::class,

            // 2. Utilisateurs et tarifs
            UtilisateurSeeder::class,
            TarifSeeder::class,

            // 3. Association des rôles aux utilisateurs administratifs
            AdherentRoleSeeder::class,
        ]);

        // 4. Données de test (faux adhérents) : uniquement hors production et si
        // FakerPHP est disponible. En prod, composer install --no-dev n'installe
        // pas Faker, donc les factories ne sont pas exécutables (fake() indéfini).
        if (! app()->isProduction() && class_exists(\Faker\Factory::class)) {
            $this->call(TestDataSeeder::class);
        } else {
            $this->command->warn('⏭️  TestDataSeeder ignoré (production ou FakerPHP absent).');
        }

        $this->command->newLine();
        $this->command->info('✅ Base de données Lyon Palme initialisée avec succès!');
    }
}
