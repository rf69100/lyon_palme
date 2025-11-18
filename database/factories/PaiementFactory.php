<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paiement>
 */
class PaiementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $moyensPaiement = ['cheque', 'especes', 'virement', 'carte_bancaire', 'paypal', 'helloasso'];
        $moyenPaiement = fake()->randomElement($moyensPaiement);

        $payeLe = fake()->dateTimeBetween('-6 months', 'now');
        $deposeLe = in_array($moyenPaiement, ['cheque'])
            ? fake()->dateTimeBetween($payeLe, '+15 days')
            : null;

        $statuts = ['valide', 'valide', 'valide', 'en_attente', 'rejete'];

        $referencePaiement = null;
        $nomBanque = null;
        $numeroCheque = null;

        if ($moyenPaiement === 'cheque') {
            $banques = ['Crédit Agricole', 'Société Générale', 'BNP Paribas', 'Caisse d\'Épargne', 'LCL', 'Crédit Mutuel', 'La Banque Postale'];
            $nomBanque = fake()->randomElement($banques);
            $numeroCheque = (string) fake()->numerify('##########');
        } elseif ($moyenPaiement === 'virement') {
            $referencePaiement = 'VIR-' . fake()->numerify('##########');
        } elseif ($moyenPaiement === 'carte_bancaire') {
            $referencePaiement = 'CB-' . fake()->numerify('############');
        } elseif ($moyenPaiement === 'paypal') {
            $referencePaiement = 'PAYPAL-' . fake()->uuid();
        } elseif ($moyenPaiement === 'helloasso') {
            $referencePaiement = 'HELLO-' . fake()->numerify('##########');
        }

        return [
            'montant' => fake()->randomFloat(2, 50, 500),
            'moyen_paiement' => $moyenPaiement,
            'reference_paiement' => $referencePaiement,
            'nom_banque' => $nomBanque,
            'numero_cheque' => $numeroCheque,
            'paye_le' => $payeLe,
            'depose_le' => $deposeLe,
            'statut' => fake()->randomElement($statuts),
            'remarques' => fake()->boolean(15) ? fake()->sentence() : null,
        ];
    }
}
