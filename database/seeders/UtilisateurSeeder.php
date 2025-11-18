<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $utilisateurs = [
            [
                'nom' => 'Admin Lyon Palme',
                'email' => 'admin@lyonpalme.fr',
                'email_verifie_le' => $now,
                'mot_de_passe' => Hash::make('password'),
                'doit_changer_mdp' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Président Club',
                'email' => 'president@lyonpalme.fr',
                'email_verifie_le' => $now,
                'mot_de_passe' => Hash::make('password'),
                'doit_changer_mdp' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Secrétaire',
                'email' => 'secretaire@lyonpalme.fr',
                'email_verifie_le' => $now,
                'mot_de_passe' => Hash::make('password'),
                'doit_changer_mdp' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Trésorier',
                'email' => 'tresorier@lyonpalme.fr',
                'email_verifie_le' => $now,
                'mot_de_passe' => Hash::make('password'),
                'doit_changer_mdp' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
        ];

        foreach ($utilisateurs as $utilisateur) {
            DB::table('utilisateurs')->insert($utilisateur);
        }

        $this->command->info('✓ 4 utilisateurs créés');
    }
}
