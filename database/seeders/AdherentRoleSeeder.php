<?php

namespace Database\Seeders;

use App\Models\Adherent;
use App\Models\AdherentRole;
use App\Models\Role;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdherentRoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Récupérer les utilisateurs administratifs
        $admin = Utilisateur::where('email', 'admin@lyonpalme.fr')->first();
        $president = Utilisateur::where('email', 'president@lyonpalme.fr')->first();
        $secretaire = Utilisateur::where('email', 'secretaire@lyonpalme.fr')->first();
        $tresorier = Utilisateur::where('email', 'tresorier@lyonpalme.fr')->first();

        // Récupérer les rôles
        $rolePresident = Role::where('nom', Role::PRESIDENT)->first();
        $roleSecretaire = Role::where('nom', Role::SECRETAIRE)->first();
        $roleTresorier = Role::where('nom', Role::TRESORIER)->first();

        if (! $rolePresident || ! $roleSecretaire || ! $roleTresorier) {
            $this->command->error('Les rôles n\'existent pas. Veuillez exécuter RoleSeeder d\'abord.');

            return;
        }

        $adherentsCreated = 0;
        $rolesAssigned = 0;

        // Créer/associer un adhérent pour l'admin et lui donner tous les rôles administratifs
        if ($admin) {
            $adherentAdmin = Adherent::firstOrCreate(
                ['utilisateur_id' => $admin->id],
                [
                    'civilite' => 'M.',
                    'prenom' => 'Admin',
                    'nom' => 'Lyon Palme',
                    'date_naissance' => '1980-01-01',
                    'email' => $admin->email,
                    'statut' => 'actif',
                    'est_mineur' => false,
                    'cree_le' => $now,
                    'modifie_le' => $now,
                ]
            );
            $adherentsCreated++;

            // Attribuer tous les rôles administratifs à l'admin
            foreach ([$rolePresident, $roleSecretaire, $roleTresorier] as $role) {
                AdherentRole::firstOrCreate(
                    [
                        'adherent_id' => $adherentAdmin->id,
                        'role_id' => $role->id,
                    ],
                    [
                        'attribue_le' => $now,
                        'est_actif' => true,
                        'cree_le' => $now,
                        'modifie_le' => $now,
                    ]
                );
                $rolesAssigned++;
            }
        }

        // Créer/associer un adhérent pour le président
        if ($president) {
            $adherentPresident = Adherent::firstOrCreate(
                ['utilisateur_id' => $president->id],
                [
                    'civilite' => 'M.',
                    'prenom' => 'Président',
                    'nom' => 'Club',
                    'date_naissance' => '1975-05-15',
                    'email' => $president->email,
                    'statut' => 'actif',
                    'est_mineur' => false,
                    'cree_le' => $now,
                    'modifie_le' => $now,
                ]
            );
            $adherentsCreated++;

            AdherentRole::firstOrCreate(
                [
                    'adherent_id' => $adherentPresident->id,
                    'role_id' => $rolePresident->id,
                ],
                [
                    'attribue_le' => $now,
                    'est_actif' => true,
                    'cree_le' => $now,
                    'modifie_le' => $now,
                ]
            );
            $rolesAssigned++;
        }

        // Créer/associer un adhérent pour le secrétaire
        if ($secretaire) {
            $adherentSecretaire = Adherent::firstOrCreate(
                ['utilisateur_id' => $secretaire->id],
                [
                    'civilite' => 'Mme',
                    'prenom' => 'Secrétaire',
                    'nom' => 'Club',
                    'date_naissance' => '1982-08-20',
                    'email' => $secretaire->email,
                    'statut' => 'actif',
                    'est_mineur' => false,
                    'cree_le' => $now,
                    'modifie_le' => $now,
                ]
            );
            $adherentsCreated++;

            AdherentRole::firstOrCreate(
                [
                    'adherent_id' => $adherentSecretaire->id,
                    'role_id' => $roleSecretaire->id,
                ],
                [
                    'attribue_le' => $now,
                    'est_actif' => true,
                    'cree_le' => $now,
                    'modifie_le' => $now,
                ]
            );
            $rolesAssigned++;
        }

        // Créer/associer un adhérent pour le trésorier
        if ($tresorier) {
            $adherentTresorier = Adherent::firstOrCreate(
                ['utilisateur_id' => $tresorier->id],
                [
                    'civilite' => 'M.',
                    'prenom' => 'Trésorier',
                    'nom' => 'Club',
                    'date_naissance' => '1978-03-10',
                    'email' => $tresorier->email,
                    'statut' => 'actif',
                    'est_mineur' => false,
                    'cree_le' => $now,
                    'modifie_le' => $now,
                ]
            );
            $adherentsCreated++;

            AdherentRole::firstOrCreate(
                [
                    'adherent_id' => $adherentTresorier->id,
                    'role_id' => $roleTresorier->id,
                ],
                [
                    'attribue_le' => $now,
                    'est_actif' => true,
                    'cree_le' => $now,
                    'modifie_le' => $now,
                ]
            );
            $rolesAssigned++;
        }

        $this->command->info("✓ {$adherentsCreated} adhérents créés/associés pour les utilisateurs administratifs");
        $this->command->info("✓ {$rolesAssigned} rôles attribués");
    }
}
