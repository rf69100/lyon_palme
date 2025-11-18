<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Créer les rôles dans la table personnalisée
        $roles = [
            [
                'nom' => 'president',
                'nom_affichage' => 'Président',
                'description' => 'Président du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'vice_president',
                'nom_affichage' => 'Vice-président',
                'description' => 'Vice-président du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'secretaire',
                'nom_affichage' => 'Secrétaire',
                'description' => 'Secrétaire du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'secretaire_adjoint',
                'nom_affichage' => 'Secrétaire adjoint',
                'description' => 'Secrétaire adjoint du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'tresorier',
                'nom_affichage' => 'Trésorier',
                'description' => 'Trésorier du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'coach',
                'nom_affichage' => 'Coach',
                'description' => 'Coach du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'entraineur',
                'nom_affichage' => 'Entraîneur',
                'description' => 'Entraîneur du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'resp_planning',
                'nom_affichage' => 'Responsable planning',
                'description' => 'Responsable de la gestion du planning',
                'afficher_annuaire' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'resp_materiel',
                'nom_affichage' => 'Responsable matériel',
                'description' => 'Responsable de la gestion du matériel',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'resp_communication',
                'nom_affichage' => 'Responsable communication',
                'description' => 'Responsable de la communication du club',
                'afficher_annuaire' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'adherent',
                'nom_affichage' => 'Adhérent',
                'description' => 'Adhérent du club',
                'afficher_annuaire' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
        ];

        // Insérer uniquement les rôles qui n'existent pas encore
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['nom' => $role['nom']],
                $role
            );
        }

        $this->command->info('Rôles créés avec succès!');
    }
}