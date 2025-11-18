<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Certifications FFESSM réalistes selon l'âge
        $certificationsFfessm = [
            // Plongée enfant
            'PE-12', 'PE-20', 'PE-40', 'PE-60',
            // Plongée adulte
            'N1', 'N1', 'N1', 'N2', 'N2', 'N3', 'N4', 'N5',
            // Apnée
            'A1', 'A2', 'A3', 'A4',
            // Nage avec palmes
            'NP1', 'NP2', 'NP3', 'NP4',
            // Encadrement
            'E1', 'E2', 'E3', 'E4', 'MF1', 'MF2',
            // Autres
            'RIFAP', 'RIFA Plongée', 'PA-12', 'PA-20', 'PA-40', 'PA-60',
        ];

        $certificationsPadi = [
            'Open Water', 'Advanced Open Water', 'Rescue Diver', 'Divemaster',
            'Open Water Instructor', 'Master Scuba Diver',
        ];

        $certificationsSsi = [
            'Open Water Diver', 'Advanced Adventurer', 'Stress & Rescue',
            'Dive Guide', 'Dive Control Specialist',
        ];

        $organismesAvecCertifs = [
            'FFESSM' => $certificationsFfessm,
            'PADI' => $certificationsPadi,
            'SSI' => $certificationsSsi,
            'CMAS' => ['1 Star', '2 Star', '3 Star', '4 Star'],
            'ANMP' => ['Niveau 1', 'Niveau 2', 'Niveau 3'],
        ];

        $organisme = fake()->randomElement(array_keys($organismesAvecCertifs));
        $typeCertification = fake()->randomElement($organismesAvecCertifs[$organisme]);

        $dateDelivrance = fake()->dateTimeBetween('-15 years', 'now');

        $delivreurs = [
            'Jean-Claude Dupont', 'Michel Bernard', 'Sophie Martin', 'Pierre Rousseau',
            'Marie Lefebvre', 'Alain Moreau', 'Isabelle Lambert', 'François Durand'
        ];

        return [
            'type_certification' => $typeCertification,
            'numero_certification' => strtoupper($organisme) . '-' . fake()->numerify('######'),
            'date_delivrance' => $dateDelivrance,
            'organisme_delivrance' => $organisme,
            'nom_delivreur' => fake()->randomElement($delivreurs),
            'est_courant' => fake()->boolean(85), // 85% sont les certifs courantes
            'remarques' => fake()->boolean(10) ? fake()->sentence() : null,
        ];
    }
}
