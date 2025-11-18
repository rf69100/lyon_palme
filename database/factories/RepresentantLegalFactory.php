<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RepresentantLegal>
 */
class RepresentantLegalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $civilite = fake()->randomElement(['M.', 'Mme']);
        $prenom = fake()->firstName($civilite === 'M.' ? 'male' : 'female');
        $nom = fake()->lastName();

        // Villes de Lyon et environs (souvent même adresse que l'enfant)
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
        ]);

        $domainesEmail = ['gmail.com', 'orange.fr', 'free.fr', 'hotmail.fr', 'outlook.fr', 'laposte.net', 'sfr.fr'];
        $email = strtolower($prenom) . '.' . strtolower($nom) . '@' . fake()->randomElement($domainesEmail);

        return [
            'civilite' => $civilite,
            'prenom' => $prenom,
            'nom' => $nom,
            'lien_parente' => fake()->randomElement(['Père', 'Mère', 'Tuteur légal', 'Tutrice légale']),
            'email' => $email,
            'telephone' => fake()->boolean(50) ? '04 ' . fake()->numerify('## ## ## ##') : null,
            'mobile' => fake()->randomElement(['06', '07']) . ' ' . fake()->numerify('## ## ## ##'),
            'numero_rue' => (string) fake()->numberBetween(1, 250),
            'rue' => fake()->streetName(),
            'complement_adresse' => fake()->boolean(20) ? fake()->randomElement(['Apt ' . fake()->numberBetween(1, 50), 'Bât ' . fake()->randomElement(['A', 'B', 'C'])]) : null,
            'code_postal' => $villeData['cp'],
            'ville' => $villeData['ville'],
            'pays' => 'France',
            'est_principal' => fake()->boolean(60), // 60% de chance d'être le représentant principal
            'peut_recuperer' => true,
            'autorise_sortie' => true,
            'autorise_transport' => true,
        ];
    }
}
