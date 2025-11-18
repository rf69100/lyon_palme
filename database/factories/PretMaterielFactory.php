<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PretMateriel>
 */
class PretMaterielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $preteLe = fake()->dateTimeBetween('-6 months', 'now');
        $dateRetourPrevue = fake()->dateTimeBetween($preteLe, '+3 months');

        // 70% ont été rendus
        $renduLe = fake()->boolean(70) ? fake()->dateTimeBetween($preteLe, 'now') : null;

        $etatsRetour = ['excellent', 'bon', 'bon', 'bon', 'moyen', 'abime'];

        return [
            'prete_le' => $preteLe,
            'date_retour_prevue' => $dateRetourPrevue,
            'rendu_le' => $renduLe,
            'etat_au_retour' => $renduLe ? fake()->randomElement($etatsRetour) : null,
            'remarques' => fake()->boolean(15) ? fake()->sentence() : null,
        ];
    }
}
