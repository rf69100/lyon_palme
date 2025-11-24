<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CertificatMedical>
 */
class CertificatMedicalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $delivreLe = fake()->dateTimeBetween('-2 years', 'now');
        $expireLe = fake()->dateTimeBetween($delivreLe, '+1 year');

        $typesPratique = fake()->randomElement([
            'plongee',
            'plongee,apnee',
            'plongee,nage_palmes',
            'plongee,apnee,nage_palmes',
            'apnee',
            'nage_palmes',
        ]);

        $nomsMedias = ['Dr Martin', 'Dr Durand', 'Dr Lefebvre', 'Dr Rousseau', 'Dr Bernard', 'Dr Petit', 'Dr Lambert', 'Dr Moreau'];
        $nomMedecin = fake()->randomElement($nomsMedias);

        $estMedecinFederal = fake()->boolean(30); // 30% de médecins fédéraux

        $statuts = ['valide', 'valide', 'valide', 'valide', 'expire', 'en_attente'];

        return [
            'adherent_id' => \App\Models\Adherent::factory(),
            'delivre_le' => $delivreLe,
            'expire_le' => $expireLe,
            'types_pratique' => $typesPratique,
            'nom_medecin' => $nomMedecin,
            'numero_ordre_medecin' => $estMedecinFederal ? (string) fake()->numerify('########') : null,
            'est_medecin_federal' => $estMedecinFederal,
            'restrictions' => fake()->boolean(5) ? 'Restriction profondeur 20m' : null, // 5% avec restrictions
            'questionnaire_sante_fourni' => fake()->boolean(95),
            'statut' => fake()->randomElement($statuts),
        ];
    }
}
