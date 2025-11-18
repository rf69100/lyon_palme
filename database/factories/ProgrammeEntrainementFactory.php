<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgrammeEntrainement>
 */
class ProgrammeEntrainementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titresProgrammes = [
            'Technique de palmage - Bi-palmes',
            'Endurance 1500m',
            'Sprint 100m - Séries',
            'Travail apnée dynamique',
            'Perfectionnement virage',
            'Sortie subaquatique avec bouteille',
            'Entraînement fractionné 400m',
            'Technique de départ plongé',
            'Parcours technique avec obstacles',
            'Séance récupération active',
            'Préparation compétition régionale',
            'Travail vitesse pure - 50m',
            'Nage longue distance 2000m',
            'Technique immersion',
            'Circuit training aquatique',
        ];

        $niveaux = ['tous', 'debutant', 'intermediaire', 'avance', 'competition'];

        $duree = fake()->numberBetween(45, 120); // Minutes
        $distance = fake()->numberBetween(800, 3000); // Mètres

        return [
            'titre' => fake()->randomElement($titresProgrammes),
            'niveau' => fake()->randomElement($niveaux),
            'duree_minutes' => $duree,
            'distance_totale' => $distance,
            'description' => fake()->boolean(60) ? fake()->paragraph() : null,
            'est_modele' => fake()->boolean(30), // 30% sont des modèles réutilisables
        ];
    }
}
