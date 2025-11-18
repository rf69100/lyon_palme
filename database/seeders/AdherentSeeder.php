<?php

namespace Database\Seeders;

use App\Models\Adherent;
use App\Models\RepresentantLegal;
use Illuminate\Database\Seeder;

class AdherentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 30 adhérents mineurs (30%) avec représentants légaux
        $mineurs = Adherent::factory()
            ->count(30)
            ->mineur()
            ->create();

        // Pour chaque mineur, créer 1 ou 2 représentants légaux
        foreach ($mineurs as $mineur) {
            // Premier représentant (principal)
            RepresentantLegal::factory()->create([
                'adherent_id' => $mineur->id,
                'est_principal' => true,
            ]);

            // 60% de chance d'avoir un second représentant
            if (fake()->boolean(60)) {
                RepresentantLegal::factory()->create([
                    'adherent_id' => $mineur->id,
                    'est_principal' => false,
                ]);
            }
        }

        // Créer 70 adhérents adultes (70%)
        Adherent::factory()
            ->count(70)
            ->adulte()
            ->create();

        $count = Adherent::count();
        $countMineurs = $mineurs->count();
        $countAdultes = $count - $countMineurs;
        $countRepresentants = RepresentantLegal::count();

        $this->command->info("Adherents crees avec succes!");
        $this->command->info("  - Total adherents: {$count}");
        $this->command->info("  - Mineurs: {$countMineurs} (avec {$countRepresentants} representants legaux)");
        $this->command->info("  - Adultes: {$countAdultes}");
    }
}
