<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InscriptionCompetition>
 */
class InscriptionCompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateInscription = fake()->dateTimeBetween('-3 months', 'now');

        $statuts = ['inscrit', 'inscrit', 'inscrit', 'confirme', 'qualifie', 'disqualifie', 'annule'];

        $moyensTransport = ['voiture_perso', 'covoiturage', 'train', 'bus_club', null];

        // Temps de performance (pour les compétitions terminées)
        $tempsMinutes = fake()->numberBetween(0, 30);
        $tempsSecondes = fake()->numberBetween(0, 59);
        $tempsCentiemes = fake()->numberBetween(0, 99);
        $tempsPerformance = sprintf('%02d:%02d.%02d', $tempsMinutes, $tempsSecondes, $tempsCentiemes);

        return [
            'competition_id' => \App\Models\Competition::factory(),
            'adherent_id' => \App\Models\Adherent::factory(),
            'modalite_competition_id' => \App\Models\ModaliteCompetition::factory(),
            'date_inscription' => $dateInscription,
            'statut' => fake()->randomElement($statuts),
            'moyen_transport' => fake()->randomElement($moyensTransport),
            'places_covoiturage_disponibles' => fake()->boolean(25) ? fake()->numberBetween(1, 4) : null,
            'besoin_hebergement' => fake()->boolean(30),
            'nombre_accompagnants' => fake()->boolean(20) ? fake()->numberBetween(1, 2) : 0,
            'info_hebergement' => fake()->boolean(25) ? fake()->randomElement(['Hôtel Ibis', 'Famille d\'accueil', 'Auberge de jeunesse', 'Camping']) : null,
            'temps_performance' => fake()->boolean(40) ? $tempsPerformance : null, // 40% ont un temps enregistré
            'classement' => fake()->boolean(40) ? fake()->numberBetween(1, 50) : null, // 40% ont un classement
            'remarques' => fake()->boolean(15) ? fake()->sentence() : null,
            'annule_le' => null,
            'raison_annulation' => null,
        ];
    }
}
