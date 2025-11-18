<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competition>
 */
class CompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Compétitions réalistes de nage avec palmes FFESSM région AURA
        $competitionsRegionales = [
            'Championnat AURA Sprint - Lyon',
            'Championnat AURA Endurance - Grenoble',
            'Open de Nage avec Palmes - Chambéry',
            'Critérium Régional Jeunes - Villeurbanne',
            'Coupe AURA Bi-palmes - Annecy',
            'Meeting Régional Automne - Saint-Étienne',
        ];

        $competitionsNationales = [
            'Championnat de France Sprint - Paris',
            'Championnat de France Endurance - Marseille',
            'Coupe de France - Montpellier',
            'Trophée National Jeunes - Nantes',
            'France Elite - Strasbourg',
        ];

        $estNationale = fake()->boolean(25); // 25% de compétitions nationales
        $estRegionale = !$estNationale;

        $titre = $estNationale
            ? fake()->randomElement($competitionsNationales)
            : fake()->randomElement($competitionsRegionales);

        $dateCompetition = fake()->dateTimeBetween('-1 month', '+6 months');
        $dateLimiteInscription = fake()->dateTimeBetween('-2 months', $dateCompetition);

        $lieux = $estNationale
            ? ['Paris', 'Marseille', 'Montpellier', 'Nantes', 'Strasbourg', 'Bordeaux']
            : ['Lyon', 'Grenoble', 'Chambéry', 'Villeurbanne', 'Annecy', 'Saint-Étienne', 'Valence'];

        $lieu = fake()->randomElement($lieux);

        $sites = [
            'Piscine Olympique Jean Bouin',
            'Centre Aquatique Municipal',
            'Complexe Nautique',
            'Stade Nautique',
            'Piscine Tournesol',
        ];

        $statuts = ['a_venir', 'a_venir', 'inscriptions_ouvertes', 'inscriptions_fermees', 'en_cours', 'termine'];

        return [
            'titre' => $titre,
            'organisation' => 'FFESSM',
            'comite_regional' => $estRegionale ? 'AURA' : fake()->randomElement(['AURA', 'IDF', 'PACA', 'BFC', 'NAQ']),
            'date_competition' => $dateCompetition,
            'lieu' => $lieu,
            'site' => fake()->randomElement($sites),
            'date_limite_inscription' => $dateLimiteInscription,
            'url_inscription' => 'https://ffessm.fr/inscriptions/' . fake()->slug(3),
            'participants_max' => fake()->randomElement([50, 80, 100, 120, 150, null]),
            'statut' => fake()->randomElement($statuts),
            'est_regionale' => $estRegionale,
            'est_nationale' => $estNationale,
            'necessite_hebergement' => $estNationale ? fake()->boolean(70) : fake()->boolean(20),
            'info_hebergement' => fake()->boolean(30) ? 'Hôtels partenaires disponibles - Tarif groupe' : null,
            'remarques' => fake()->boolean(20) ? fake()->sentence() : null,
        ];
    }
}
