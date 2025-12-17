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

            // 4. Données de test (décommenter pour générer des données complètes)
            TestDataSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ Base de données Lyon Palme initialisée avec succès!');
    }
}
