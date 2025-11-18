<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TarifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Tarifs réalistes pour un club de plongée
        $montants = [
            'Enfant (-12 ans)' => fake()->randomFloat(2, 150, 200),
            'Jeune (12-17 ans)' => fake()->randomFloat(2, 180, 230),
            'Adulte' => fake()->randomFloat(2, 280, 350),
            'Etudiant' => fake()->randomFloat(2, 200, 250),
            'Famille' => fake()->randomFloat(2, 450, 600),
            'Compétition' => fake()->randomFloat(2, 350, 450),
        ];

        $typeAdhesion = fake()->randomElement(array_keys($montants));
        $montant = $montants[$typeAdhesion];

        $valideDu = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'montant' => $montant,
            'description' => 'Cotisation annuelle ' . $typeAdhesion,
            'valide_du' => $valideDu,
            'valide_jusque' => fake()->boolean(80) ? fake()->dateTimeBetween($valideDu, '+2 years') : null,
            'est_actif' => fake()->boolean(85),
        ];
    }
}
