<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adherent>
 */
class AdherentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Déterminer si c'est un mineur (30% de chance)
        $estMineur = fake()->boolean(30);

        if ($estMineur) {
            // Enfants: 8-17 ans
            $dateNaissance = fake()->dateTimeBetween('-17 years', '-8 years');
        } else {
            // Adultes: 18-75 ans (plus d'adultes jeunes/moyens que de seniors)
            $dateNaissance = fake()->dateTimeBetween('-75 years', '-18 years');
        }

        $civilite = fake()->randomElement(['M.', 'Mme', 'Mlle']);
        $prenom = fake()->firstName($civilite === 'M.' ? 'male' : 'female');
        $nom = fake()->lastName();

        // Villes de Lyon et environs
        $villeData = fake()->randomElement([
            ['ville' => 'Lyon 1er', 'cp' => '69001'],
            ['ville' => 'Lyon 2e', 'cp' => '69002'],
            ['ville' => 'Lyon 3e', 'cp' => '69003'],
            ['ville' => 'Lyon 4e', 'cp' => '69004'],
            ['ville' => 'Lyon 5e', 'cp' => '69005'],
            ['ville' => 'Lyon 6e', 'cp' => '69006'],
            ['ville' => 'Lyon 7e', 'cp' => '69007'],
            ['ville' => 'Lyon 8e', 'cp' => '69008'],
            ['ville' => 'Villeurbanne', 'cp' => '69100'],
            ['ville' => 'Vénissieux', 'cp' => '69200'],
            ['ville' => 'Caluire-et-Cuire', 'cp' => '69300'],
            ['ville' => 'Bron', 'cp' => '69500'],
            ['ville' => 'Oullins', 'cp' => '69600'],
            ['ville' => 'Saint-Fons', 'cp' => '69190'],
            ['ville' => 'Décines-Charpieu', 'cp' => '69150'],
            ['ville' => 'Meyzieu', 'cp' => '69330'],
        ]);

        // Domaines email français variés
        $domainesEmail = ['gmail.com', 'orange.fr', 'free.fr', 'hotmail.fr', 'outlook.fr', 'laposte.net', 'sfr.fr', 'wanadoo.fr'];
        $email = strtolower(fake()->lexify('???')) . '.' . strtolower($nom) . '@' . fake()->randomElement($domainesEmail);

        // Contacts urgence
        $contactNom = fake()->firstName() . ' ' . fake()->lastName();
        $liensParente = ['Conjoint(e)', 'Père', 'Mère', 'Frère', 'Soeur', 'Ami(e) proche', 'Voisin(e)'];

        return [
            'civilite' => $civilite,
            'prenom' => $prenom,
            'nom' => $nom,
            'date_naissance' => $dateNaissance,
            'email' => $email,
            'telephone' => fake()->boolean(40) ? '06 ' . fake()->numerify('## ## ## ##') : null,
            'mobile' => fake()->randomElement(['06', '07']) . ' ' . fake()->numerify('## ## ## ##'),
            'numero_rue' => (string) fake()->numberBetween(1, 250),
            'rue' => fake()->streetName(),
            'complement_adresse' => fake()->boolean(20) ? fake()->randomElement(['Apt ' . fake()->numberBetween(1, 50), 'Bât ' . fake()->randomElement(['A', 'B', 'C']), 'Rez-de-chaussée', 'Étage ' . fake()->numberBetween(1, 6)]) : null,
            'code_postal' => $villeData['cp'],
            'ville' => $villeData['ville'],
            'pays' => 'France',
            'contact_urgence_nom' => $contactNom,
            'contact_urgence_telephone' => fake()->randomElement(['06', '07']) . ' ' . fake()->numerify('## ## ## ##'),
            'contact_urgence_lien' => fake()->randomElement($liensParente),
            'statut' => fake()->randomElement(['actif', 'actif', 'actif', 'actif', 'actif', 'actif', 'inactif', 'radie']), // 75% actif
            'archive_le' => null,
            'est_mineur' => $estMineur,
        ];
    }

    /**
     * Adhérent mineur
     */
    public function mineur(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_naissance' => fake()->dateTimeBetween('-17 years', '-8 years'),
            'est_mineur' => true,
        ]);
    }

    /**
     * Adhérent adulte
     */
    public function adulte(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_naissance' => fake()->dateTimeBetween('-65 years', '-18 years'),
            'est_mineur' => false,
        ]);
    }

    /**
     * Adhérent senior
     */
    public function senior(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_naissance' => fake()->dateTimeBetween('-75 years', '-65 years'),
            'est_mineur' => false,
        ]);
    }
}
