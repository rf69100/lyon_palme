<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TarifSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $saisonCourante = DB::table('saisons')->where('est_courante', true)->first();
        
        if (!$saisonCourante) {
            $this->command->warn('Aucune saison courante trouvée');
            return;
        }

        $typesAdhesion = DB::table('types_adhesion')->get();

        // Grille tarifaire 2024-2025
        $tarifsMap = [
            'Adulte' => 320.00,
            'Jeune' => 220.00,
            'Étudiant' => 250.00,
            'Demandeur d\'emploi' => 200.00,
            'Famille' => 550.00,
        ];

        foreach ($typesAdhesion as $type) {
            $montant = $tarifsMap[$type->nom] ?? 300.00;
            
            DB::table('tarifs')->insert([
                'saison_id' => $saisonCourante->id,
                'type_adhesion_id' => $type->id,
                'montant' => $montant,
                'description' => "Tarif {$type->nom} saison {$saisonCourante->nom}",
                'valide_du' => $saisonCourante->date_debut,
                'valide_jusque' => $saisonCourante->date_fin,
                'est_actif' => true,
                'cree_le' => $now,
                'modifie_le' => $now,
            ]);
        }

        $this->command->info('✓ ' . $typesAdhesion->count() . ' tarifs créés pour la saison ' . $saisonCourante->nom);
    }
}
