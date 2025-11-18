<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TypeMaterielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $typesMateriel = [
            ['nom' => 'Monopalme', 'description' => 'Palme unique pour nage avec palmes', 'a_taille' => true, 'a_marque' => true],
            ['nom' => 'Bi-palmes', 'description' => 'Paire de palmes pour nage avec palmes', 'a_taille' => true, 'a_marque' => true],
            ['nom' => 'Palmes courtes', 'description' => 'Palmes courtes d\'entraînement', 'a_taille' => true, 'a_marque' => true],
            ['nom' => 'Combinaison', 'description' => 'Combinaison de plongée', 'a_taille' => true, 'a_marque' => true],
            ['nom' => 'Détendeur', 'description' => 'Détendeur de plongée', 'a_taille' => false, 'a_marque' => true],
            ['nom' => 'Gilet stabilisateur', 'description' => 'Gilet stabilisateur (stab)', 'a_taille' => true, 'a_marque' => true],
            ['nom' => 'Masque', 'description' => 'Masque de plongée', 'a_taille' => false, 'a_marque' => true],
            ['nom' => 'Tuba', 'description' => 'Tuba frontal pour nage avec palmes', 'a_taille' => false, 'a_marque' => true],
            ['nom' => 'Bouteille', 'description' => 'Bouteille de plongée', 'a_taille' => false, 'a_marque' => true],
            ['nom' => 'Lestage', 'description' => 'Ceinture de lestage', 'a_taille' => false, 'a_marque' => false],
            ['nom' => 'Ordinateur', 'description' => 'Ordinateur de plongée', 'a_taille' => false, 'a_marque' => true],
            ['nom' => 'Parachute', 'description' => 'Parachute de palier', 'a_taille' => false, 'a_marque' => true],
        ];

        static $index = 0;
        $type = $typesMateriel[$index % count($typesMateriel)];
        $index++;

        return $type;
    }
}
