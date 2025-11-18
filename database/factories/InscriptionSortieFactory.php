<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InscriptionSortie>
 */
class InscriptionSortieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateInscription = fake()->dateTimeBetween('-2 months', 'now');

        $statuts = ['inscrit', 'inscrit', 'inscrit', 'confirme', 'liste_attente', 'annule'];

        $moyensTransport = ['voiture_perso', 'covoiturage', 'train', 'bus_club', null];

        return [
            'date_inscription' => $dateInscription,
            'statut' => fake()->randomElement($statuts),
            'moyen_transport' => fake()->randomElement($moyensTransport),
            'places_covoiturage_disponibles' => fake()->boolean(30) ? fake()->numberBetween(1, 4) : null,
            'nombre_accompagnants' => fake()->boolean(20) ? fake()->numberBetween(1, 3) : 0,
            'remarques' => fake()->boolean(15) ? fake()->sentence() : null,
            'annule_le' => null,
            'raison_annulation' => null,
        ];
    }
}
