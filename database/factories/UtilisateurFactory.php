<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Utilisateur>
 */
class UtilisateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prenom = fake()->firstName();
        $nom = fake()->lastName();

        return [
            'nom' => $nom . ' ' . $prenom,
            'email' => fake()->unique()->safeEmail(),
            'email_verifie_le' => fake()->boolean(70) ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'mot_de_passe' => bcrypt('password'), // Hash bcrypt par défaut
            'doit_changer_mdp' => fake()->boolean(30),
        ];
    }
}
