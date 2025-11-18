<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TypeMaterielSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $typesMateriel = [
            [
                'nom' => 'Palmes',
                'description' => 'Palmes de natation/plongée',
                'a_taille' => true,
                'a_marque' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Masque',
                'description' => 'Masque de plongée',
                'a_taille' => false,
                'a_marque' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Tuba',
                'description' => 'Tuba de plongée',
                'a_taille' => false,
                'a_marque' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Combinaison',
                'description' => 'Combinaison de plongée',
                'a_taille' => true,
                'a_marque' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Bouée de signalisation',
                'description' => 'Bouée de signalisation pour la sécurité',
                'a_taille' => false,
                'a_marque' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Lestage',
                'description' => 'Ceinture et plombs de lestage',
                'a_taille' => false,
                'a_marque' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Plaquettes',
                'description' => 'Plaquettes pour l\'entraînement',
                'a_taille' => true,
                'a_marque' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => 'Pull-buoy',
                'description' => 'Pull-buoy pour l\'entraînement',
                'a_taille' => false,
                'a_marque' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
        ];

        // Insérer uniquement les types qui n'existent pas encore
        foreach ($typesMateriel as $type) {
            DB::table('types_materiel')->updateOrInsert(
                ['nom' => $type['nom']],
                $type
            );
        }

        $this->command->info('Types de matériel créés avec succès!');
    }
}
