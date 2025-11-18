<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeanceEntrainement>
 */
class SeanceEntrainementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Piscines de la région lyonnaise
        $piscines = [
            ['nom' => 'Centre Nautique de Vénissieux', 'longueur' => 25],
            ['nom' => 'Piscine de Gerland', 'longueur' => 50],
            ['nom' => 'Centre Aquatique du Grand Lyon', 'longueur' => 25],
            ['nom' => 'Piscine Mermoz', 'longueur' => 25],
            ['nom' => 'Piscine de la Duchère', 'longueur' => 25],
        ];

        $piscineData = fake()->randomElement($piscines);

        // Créneaux horaires typiques d'entraînement
        $creneaux = [
            ['debut' => '18:00', 'fin' => '19:30'],
            ['debut' => '19:00', 'fin' => '20:30'],
            ['debut' => '19:30', 'fin' => '21:00'],
            ['debut' => '20:00', 'fin' => '21:30'],
            ['debut' => '12:00', 'fin' => '13:30'], // Midi
            ['debut' => '14:00', 'fin' => '15:30'], // Mercredi après-midi
        ];

        $creneau = fake()->randomElement($creneaux);

        $dateSeance = fake()->dateTimeBetween('-3 months', '+2 months');

        $niveauxRequis = ['tous', 'debutant', 'intermediaire', 'avance', 'competition', 'N1', 'N2+'];

        $statuts = ['planifie', 'planifie', 'planifie', 'termine', 'termine', 'annule'];

        return [
            'date_seance' => $dateSeance,
            'heure_debut' => $creneau['debut'],
            'heure_fin' => $creneau['fin'],
            'piscine' => $piscineData['nom'],
            'longueur_bassin' => $piscineData['longueur'],
            'participants_max' => fake()->randomElement([15, 20, 25, 30, null]),
            'niveau_requis' => fake()->randomElement($niveauxRequis),
            'statut' => fake()->randomElement($statuts),
            'raison_annulation' => null,
            'remarques' => fake()->boolean(20) ? fake()->sentence() : null,
        ];
    }
}
