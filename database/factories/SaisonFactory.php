<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SaisonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $annee = 2024;

        $dateDebut = fake()->dateTimeBetween("$annee-09-01", "$annee-09-15");
        $dateFin = fake()->dateTimeBetween(($annee + 1) . "-06-15", ($annee + 1) . "-06-30");

        $nom = "$annee-" . ($annee + 1);
        $annee++;

        return [
            'nom' => $nom,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'est_courante' => fake()->boolean(20), // 20% de chance d'être la saison courante
        ];
    }
}
