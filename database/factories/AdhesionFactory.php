<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adhesion>
 */
class AdhesionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $montantAttendu = fake()->randomFloat(2, 150, 500);
        $montantPaye = fake()->randomElement([
            0, // Pas encore payé
            $montantAttendu, // Payé en totalité
            $montantAttendu / 2, // Payé à moitié
            $montantAttendu * 0.3, // Acompte
        ]);

        $statuts = ['valide', 'valide', 'valide', 'en_attente', 'incomplete'];
        $statut = fake()->randomElement($statuts);

        $dateInscription = fake()->dateTimeBetween('-6 months', 'now');
        $valideLe = ($statut === 'valide') ? fake()->dateTimeBetween($dateInscription, 'now') : null;

        return [
            'adherent_id' => \App\Models\Adherent::factory(),
            'saison_id' => \App\Models\Saison::factory()->state(['nom' => 'test-' . uniqid()]),
            'type_adhesion_id' => \App\Models\TypeAdhesion::factory(),
            'tarif_id' => \App\Models\Tarif::factory(),
            'montant_attendu' => $montantAttendu,
            'montant_paye' => $montantPaye,
            // 'solde' est une colonne générée automatiquement
            'date_inscription' => $dateInscription,
            'statut' => $statut,
            'valide_le' => $valideLe,
            'numero_recu' => $statut === 'valide' ? 'REC-' . fake()->year() . '-' . fake()->unique()->numberBetween(1000, 9999) : null,
            'remarques' => fake()->boolean(20) ? fake()->sentence() : null,
        ];
    }
}
