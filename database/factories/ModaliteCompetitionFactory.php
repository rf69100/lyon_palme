<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ModaliteCompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Distances officielles nage avec palmes
        $distances = [50, 100, 200, 400, 800, 1500];
        $distance = fake()->randomElement($distances);

        // Types d'équipement
        $typesEquipement = ['monopalme', 'bipalmes', 'palmes_classiques'];
        $typeEquipement = fake()->randomElement($typesEquipement);

        // Relais ou individuel
        $estRelais = fake()->boolean(20); // 20% de relais

        // Catégories d'âge FFESSM
        $categories = [
            'Avenirs (8-11 ans)',
            'Jeunes (12-14 ans)',
            'Juniors (15-17 ans)',
            'Seniors (18-34 ans)',
            'Masters 1 (35-44 ans)',
            'Masters 2 (45-54 ans)',
            'Masters 3 (55+ ans)',
        ];

        return [
            'competition_id' => \App\Models\Competition::factory(),
            'distance' => $distance,
            'type_equipement' => $typeEquipement,
            'est_relais' => $estRelais,
            'categorie' => fake()->randomElement($categories),
            'participants_max' => fake()->randomElement([8, 10, 12, 16, null]),
        ];
    }
}
