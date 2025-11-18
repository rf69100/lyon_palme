<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sortie>
 */
class SortieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Sites de plongée réalistes depuis Lyon
        $sitesMer = [
            ['lieu' => 'Marseille - Calanques', 'zone' => 'Île Maïre'],
            ['lieu' => 'Marseille - Frioul', 'zone' => 'Le Pharillon'],
            ['lieu' => 'Cassis', 'zone' => 'La Cassidaigne'],
            ['lieu' => 'Port-Cros', 'zone' => 'La Gabinière'],
            ['lieu' => 'Port-Cros', 'zone' => 'Pointe de l\'Observatoire'],
            ['lieu' => 'Lavandou', 'zone' => 'Sec de la Fourmigue'],
            ['lieu' => 'Antibes', 'zone' => 'Pointe de l\'Îlette'],
            ['lieu' => 'Marseille', 'zone' => 'Épave du Chaouen'],
            ['lieu' => 'Saint-Raphaël', 'zone' => 'Roc du Dramont'],
        ];

        $sitesLac = [
            ['lieu' => 'Lac d\'Annecy', 'zone' => 'Les Marquisats'],
            ['lieu' => 'Lac d\'Annecy', 'zone' => 'Roc de Chère'],
            ['lieu' => 'Lac du Bourget', 'zone' => 'Conjux'],
            ['lieu' => 'Lac de Tignes', 'zone' => 'Village englouti'],
            ['lieu' => 'Lac de Nantua', 'zone' => 'Plage municipale'],
            ['lieu' => 'Lac d\'Aiguebelette', 'zone' => 'Attignat-Oncin'],
        ];

        $fosses = [
            ['lieu' => 'Y-40 (Italie)', 'zone' => 'Fosse 42m'],
            ['lieu' => 'Todi (Belgique)', 'zone' => 'Fosse 10m'],
        ];

        $typeSortie = fake()->randomElement(['loisir', 'loisir', 'loisir', 'formation', 'exploration', 'technique']);

        // Choisir entre mer, lac ou fosse
        $destination = fake()->randomElement(['mer', 'mer', 'mer', 'lac', 'lac', 'fosse']);

        if ($destination === 'mer') {
            $site = fake()->randomElement($sitesMer);
        } elseif ($destination === 'lac') {
            $site = fake()->randomElement($sitesLac);
        } else {
            $site = fake()->randomElement($fosses);
        }

        $dateSortie = fake()->dateTimeBetween('-2 months', '+6 months');

        $heuresRdv = ['07:00', '07:30', '08:00', '08:30', '14:00'];
        $heureRdv = fake()->randomElement($heuresRdv);

        $niveauxRequis = ['tous', 'N1', 'N2', 'N1+', 'N2+', 'PE-20'];

        $statuts = ['planifie', 'planifie', 'planifie', 'confirme', 'termine', 'annule'];

        $conditionsMeteo = ['Ensoleillé', 'Nuageux', 'Mer calme', 'Mer agitée', 'Pluie'];
        $temperatureEau = fake()->randomFloat(1, 12, 24);

        return [
            'titre' => 'Sortie ' . $site['lieu'],
            'type_sortie' => $typeSortie,
            'date_sortie' => $dateSortie,
            'heure_rendez_vous' => $heureRdv,
            'heure_debut' => fake()->time('H:i', strtotime($heureRdv . ' +2 hours')),
            'lieu' => $site['lieu'],
            'zone_plage' => $site['zone'],
            'niveau_requis' => fake()->randomElement($niveauxRequis),
            'participants_max' => fake()->randomElement([12, 15, 20, 25, null]),
            'consignes_securite' => 'Bonnet de couleur et bouée de signalisation obligatoires',
            'remarques_complementaires' => fake()->boolean(30) ? fake()->sentence() : null,
            'conditions_meteo' => fake()->randomElement($conditionsMeteo),
            'temperature_eau' => $temperatureEau,
            'statut' => fake()->randomElement($statuts),
            'raison_annulation' => null,
        ];
    }
}
