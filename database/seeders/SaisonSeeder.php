<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Créer la saison courante 2024-2025
        $saisons = [
            [
                'nom' => '2024-2025',
                'date_debut' => '2024-09-01',
                'date_fin' => '2025-08-31',
                'est_courante' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
            [
                'nom' => '2023-2024',
                'date_debut' => '2023-09-01',
                'date_fin' => '2024-08-31',
                'est_courante' => false,
                'cree_le' => $now,
                'modifie_le' => $now,
            ],
        ];

        // Insérer uniquement les saisons qui n'existent pas encore
        foreach ($saisons as $saison) {
            DB::table('saisons')->updateOrInsert(
                ['nom' => $saison['nom']],
                $saison
            );
        }

        $this->command->info('Saisons créées avec succès!');
    }
}
