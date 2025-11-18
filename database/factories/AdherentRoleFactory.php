<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdherentRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attribueLe = fake()->dateTimeBetween('-2 years', 'now');

        return [
            'attribue_le' => $attribueLe,
            'revoque_le' => fake()->boolean(10) ? fake()->dateTimeBetween($attribueLe, 'now') : null, // 10% révoqués
            'est_actif' => fake()->boolean(90), // 90% actifs
        ];
    }
}
