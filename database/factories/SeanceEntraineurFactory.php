<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SeanceEntraineurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rolesSeance = ['responsable', 'assistant', 'observateur'];

        return [
            'role_seance' => fake()->randomElement($rolesSeance),
            'confirme' => fake()->boolean(90), // 90% confirment leur présence
            'raison_indisponibilite' => fake()->boolean(10) ? fake()->randomElement(['Maladie', 'Indisponibilité professionnelle', 'Congés', 'Imprévu personnel']) : null,
            'echange_approuve' => fake()->boolean(5), // 5% demandent un échange
            'echange_approuve_le' => null,
        ];
    }
}
