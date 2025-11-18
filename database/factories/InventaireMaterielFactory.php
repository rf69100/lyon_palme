<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventaireMateriel>
 */
class InventaireMaterielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Marques de matériel de plongée
        $marquesMonopalmes = ['Leaderfins', 'C4', 'Cressi', 'Omer', 'Pathos'];
        $marquesBipalmes = ['Arena', 'Finis', 'Beuchat', 'Mares', 'Cressi'];
        $marquesCombis = ['Beuchat', 'Scubapro', 'Aqualung', 'Mares', 'Cressi'];
        $marquesDetendeurs = ['Scubapro', 'Aqualung', 'Apeks', 'Mares', 'Cressi'];
        $marquesStabs = ['Scubapro', 'Aqualung', 'Mares', 'Cressi', 'Beuchat'];

        $marqueGenerique = fake()->randomElement($marquesBipalmes);

        // Tailles pour différents types de matériel
        $taillesPalmes = ['36-38', '38-40', '40-42', '42-44', '44-46'];
        $taillesCombis = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $taillesStabs = ['S', 'M', 'L', 'XL'];

        $taille = fake()->randomElement($taillesPalmes);

        $dateAchat = fake()->dateTimeBetween('-8 years', '-1 month');
        $prixAchat = fake()->randomFloat(2, 50, 800);

        $etats = ['excellent', 'bon', 'bon', 'bon', 'moyen', 'usagé', 'à réviser'];
        $statuts = ['disponible', 'disponible', 'disponible', 'prete', 'en_reparation', 'hors_service'];

        static $numeroMateriel = 1;
        $codeMateriel = 'MAT-' . str_pad($numeroMateriel, 4, '0', STR_PAD_LEFT);
        $numeroMateriel++;

        return [
            'code_materiel' => $codeMateriel,
            'marque' => $marqueGenerique,
            'taille_ou_pointure' => $taille,
            'date_achat' => $dateAchat,
            'prix_achat' => $prixAchat,
            'etat' => fake()->randomElement($etats),
            'statut' => fake()->randomElement($statuts),
            'remarques' => fake()->boolean(20) ? fake()->sentence() : null,
        ];
    }
}
