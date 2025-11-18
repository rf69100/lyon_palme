<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TypeAdhesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $typesAdhesion = [
            [
                'nom' => 'Adulte',
                'description' => 'Adhésion pour les adultes (18 ans et plus)',
                'necessite_justificatif' => false,
                'est_actif' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Jeune',
                'description' => 'Adhésion pour les jeunes (moins de 18 ans)',
                'necessite_justificatif' => false,
                'est_actif' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Étudiant',
                'description' => 'Adhésion tarif étudiant',
                'necessite_justificatif' => true,
                'est_actif' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Demandeur d\'emploi',
                'description' => 'Adhésion tarif demandeur d\'emploi',
                'necessite_justificatif' => true,
                'est_actif' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Famille',
                'description' => 'Adhésion famille (3 membres minimum)',
                'necessite_justificatif' => false,
                'est_actif' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
        ];

        // Insérer uniquement les types qui n'existent pas encore
        foreach ($typesAdhesion as $type) {
            DB::table('types_adhesion')->updateOrInsert(
                ['nom' => $type['nom']],
                $type
            );
        }

        $this->command->info('Types d\'adhésion créés avec succès!');
    }
}
