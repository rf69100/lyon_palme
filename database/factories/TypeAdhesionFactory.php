<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TypeAdhesionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            [
                'nom' => 'Enfant (-12 ans)',
                'description' => 'Adhésion pour les enfants de moins de 12 ans',
                'necessite_justificatif' => true,
                'est_actif' => true
            ],
            [
                'nom' => 'Jeune (12-17 ans)',
                'description' => 'Adhésion pour les jeunes de 12 à 17 ans',
                'necessite_justificatif' => true,
                'est_actif' => true
            ],
            [
                'nom' => 'Adulte',
                'description' => 'Adhésion adulte standard',
                'necessite_justificatif' => false,
                'est_actif' => true
            ],
            [
                'nom' => 'Etudiant',
                'description' => 'Adhésion à tarif réduit pour les étudiants',
                'necessite_justificatif' => true,
                'est_actif' => true
            ],
            [
                'nom' => 'Famille',
                'description' => 'Adhésion famille (2 adultes + enfants)',
                'necessite_justificatif' => false,
                'est_actif' => true
            ],
            [
                'nom' => 'Compétition',
                'description' => 'Adhésion incluant licence compétition FFESSM',
                'necessite_justificatif' => false,
                'est_actif' => true
            ],
        ];

        static $index = 0;
        $type = $types[$index % count($types)];
        $index++;

        return $type;
    }
}
