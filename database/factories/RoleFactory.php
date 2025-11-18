<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            ['nom' => 'adherent', 'nom_affichage' => 'Adhérent', 'description' => 'Membre du club', 'afficher_annuaire' => true],
            ['nom' => 'entraineur', 'nom_affichage' => 'Entraîneur', 'description' => 'Encadrant les séances d\'entraînement', 'afficher_annuaire' => true],
            ['nom' => 'moniteur', 'nom_affichage' => 'Moniteur', 'description' => 'Moniteur fédéral (MF1/MF2)', 'afficher_annuaire' => true],
            ['nom' => 'directeur_technique', 'nom_affichage' => 'Directeur Technique', 'description' => 'Responsable technique du club', 'afficher_annuaire' => true],
            ['nom' => 'president', 'nom_affichage' => 'Président', 'description' => 'Président du club', 'afficher_annuaire' => true],
            ['nom' => 'tresorier', 'nom_affichage' => 'Trésorier', 'description' => 'Gestion financière', 'afficher_annuaire' => true],
            ['nom' => 'secretaire', 'nom_affichage' => 'Secrétaire', 'description' => 'Gestion administrative', 'afficher_annuaire' => true],
            ['nom' => 'bureau', 'nom_affichage' => 'Membre du Bureau', 'description' => 'Membre du bureau directeur', 'afficher_annuaire' => true],
            ['nom' => 'gestionnaire_materiel', 'nom_affichage' => 'Gestionnaire Matériel', 'description' => 'Gestion du matériel du club', 'afficher_annuaire' => false],
        ];

        static $index = 0;
        $role = $roles[$index % count($roles)];
        $index++;

        return $role;
    }
}
