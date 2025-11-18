<?php

namespace Database\Seeders;

use App\Models\Adherent;
use App\Models\Adhesion;
use App\Models\CertificatMedical;
use App\Models\Certification;
use App\Models\Competition;
use App\Models\Document;
use App\Models\InscriptionCompetition;
use App\Models\InscriptionSortie;
use App\Models\InventaireMateriel;
use App\Models\ModaliteCompetition;
use App\Models\Paiement;
use App\Models\PretMateriel;
use App\Models\ProgrammeEntrainement;
use App\Models\RepresentantLegal;
use App\Models\SeanceEntrainement;
use App\Models\SeanceEntraineur;
use App\Models\Sortie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Génère des données de test complètes pour le club Lyon Palme
     */
    public function run(): void
    {
        $this->command->info('🏊 Génération des données de test pour Lyon Palme...');
        $this->command->newLine();

        // Récupérer les IDs nécessaires
        $saisonCourante = DB::table('saisons')->where('est_courante', true)->first();
        $tarifs = DB::table('tarifs')->where('saison_id', $saisonCourante->id)->get();

        // 1. Créer des adhérents (80-100)
        $this->command->info('1️⃣  Création des adhérents...');

        // 30 mineurs (avec représentants légaux)
        $mineurs = Adherent::factory()
            ->count(30)
            ->mineur()
            ->create();

        foreach ($mineurs as $mineur) {
            RepresentantLegal::factory()
                ->count(rand(1, 2))
                ->create(['adherent_mineur_id' => $mineur->id]);
        }

        // 70 adultes
        $adultes = Adherent::factory()
            ->count(70)
            ->adulte()
            ->create();

        $adherents = $mineurs->merge($adultes);
        $this->command->info("   ✓ {$adherents->count()} adhérents créés (30 mineurs, 70 adultes)");

        // 2. Créer des adhésions pour tous
        $this->command->info('2️⃣  Création des adhésions...');
        $adhesionsCount = 0;

        foreach ($adherents as $adherent) {
            // Déterminer le type d'adhésion selon l'âge
            $age = \Carbon\Carbon::parse($adherent->date_naissance)->age;
            $typeAdhesion = match(true) {
                $age < 12 => DB::table('types_adhesion')->where('nom', 'like', '%Enfant%')->orWhere('nom', 'like', '%Jeune%')->first(),
                $age < 18 => DB::table('types_adhesion')->where('nom', 'like', '%Jeune%')->first(),
                $age < 26 && rand(0, 100) < 30 => DB::table('types_adhesion')->where('nom', 'like', '%Étudiant%')->first(),
                default => DB::table('types_adhesion')->where('nom', 'like', '%Adulte%')->first(),
            };

            if (!$typeAdhesion) {
                $typeAdhesion = DB::table('types_adhesion')->first();
            }

            $tarif = $tarifs->firstWhere('type_adhesion_id', $typeAdhesion->id);

            if ($tarif) {
                $adhesion = Adhesion::factory()->create([
                    'adherent_id' => $adherent->id,
                    'saison_id' => $saisonCourante->id,
                    'type_adhesion_id' => $typeAdhesion->id,
                    'tarif_id' => $tarif->id,
                    'montant_attendu' => $tarif->montant,
                ]);

                // Créer 1-3 paiements
                $nombrePaiements = rand(1, 3);
                $montantRestant = $adhesion->montant_attendu;

                for ($i = 0; $i < $nombrePaiements && $montantRestant > 0; $i++) {
                    $montantPaiement = ($i == $nombrePaiements - 1)
                        ? $montantRestant
                        : min(rand(50, 150), $montantRestant);

                    Paiement::factory()->create([
                        'adhesion_id' => $adhesion->id,
                        'montant' => $montantPaiement,
                    ]);

                    $montantRestant -= $montantPaiement;
                }

                $adhesionsCount++;
            }
        }

        $this->command->info("   ✓ {$adhesionsCount} adhésions créées avec paiements");

        // 3. Certificats médicaux (90% des adhérents)
        $this->command->info('3️⃣  Création des certificats médicaux...');
        $certificatsCount = 0;

        foreach ($adherents->random(90) as $adherent) {
            CertificatMedical::factory()->create([
                'adherent_id' => $adherent->id,
            ]);
            $certificatsCount++;
        }

        $this->command->info("   ✓ {$certificatsCount} certificats médicaux créés");

        // 4. Certifications (selon l'âge)
        $this->command->info('4️⃣  Création des certifications...');
        $certificationsCount = 0;

        foreach ($adherents as $adherent) {
            $age = \Carbon\Carbon::parse($adherent->date_naissance)->age;
            $nombreCertifications = match(true) {
                $age < 12 => rand(0, 1),
                $age < 18 => rand(1, 2),
                default => rand(1, 3),
            };

            for ($i = 0; $i < $nombreCertifications; $i++) {
                Certification::factory()->create([
                    'adherent_id' => $adherent->id,
                ]);
                $certificationsCount++;
            }
        }

        $this->command->info("   ✓ {$certificationsCount} certifications créées");

        // 5. Matériel
        $this->command->info('5️⃣  Création de l\'inventaire matériel...');

        $typesM = DB::table('types_materiel')->get();
        $materielCount = 0;

        foreach ($typesM as $type) {
            $nombre = match($type->nom) {
                'Palmes' => 30,
                'Masque' => 20,
                'Tuba' => 20,
                'Combinaison' => 25,
                default => rand(5, 15),
            };

            for ($i = 0; $i < $nombre; $i++) {
                InventaireMateriel::factory()->create([
                    'type_materiel_id' => $type->id,
                ]);
                $materielCount++;
            }
        }

        $this->command->info("   ✓ {$materielCount} pièces de matériel créées");

        // 6. Séances d'entraînement
        $this->command->info('6️⃣  Création des séances d\'entraînement...');

        $seances = SeanceEntrainement::factory()
            ->count(50)
            ->create(['saison_id' => $saisonCourante->id]);

        $this->command->info("   ✓ {$seances->count()} séances d'entraînement créées");

        // 7. Programmes d'entraînement
        $programmes = ProgrammeEntrainement::factory()
            ->count(20)
            ->create(['auteur_adherent_id' => $adherents->random()->id]);

        $this->command->info("   ✓ {$programmes->count()} programmes d'entraînement créés");

        // 8. Sorties
        $this->command->info('7️⃣  Création des sorties...');

        $sorties = Sortie::factory()
            ->count(25)
            ->create([
                'saison_id' => $saisonCourante->id,
                'organisateur_adherent_id' => $adherents->random()->id,
            ]);

        // Inscriptions aux sorties
        $inscriptionsSortiesCount = 0;
        foreach ($sorties as $sortie) {
            $participants = $adherents->random(rand(5, 20));

            foreach ($participants as $participant) {
                InscriptionSortie::factory()->create([
                    'sortie_id' => $sortie->id,
                    'adherent_id' => $participant->id,
                ]);
                $inscriptionsSortiesCount++;
            }
        }

        $this->command->info("   ✓ {$sorties->count()} sorties créées avec {$inscriptionsSortiesCount} inscriptions");

        // 9. Compétitions
        $this->command->info('8️⃣  Création des compétitions...');

        $competitions = Competition::factory()
            ->count(12)
            ->create(['saison_id' => $saisonCourante->id]);

        $inscriptionsCompCount = 0;
        foreach ($competitions as $competition) {
            // Modalités
            $modalites = ModaliteCompetition::factory()
                ->count(rand(3, 6))
                ->create(['competition_id' => $competition->id]);

            // Inscriptions
            $competiteurs = $adultes->random(rand(5, 15));

            foreach ($competiteurs as $competiteur) {
                InscriptionCompetition::factory()->create([
                    'competition_id' => $competition->id,
                    'adherent_id' => $competiteur->id,
                    'modalite_competition_id' => $modalites->random()->id,
                ]);
                $inscriptionsCompCount++;
            }
        }

        $this->command->info("   ✓ {$competitions->count()} compétitions créées avec {$inscriptionsCompCount} inscriptions");

        // 10. Documents
        $this->command->info('9️⃣  Création des documents...');
        $documentsCount = 0;

        foreach ($adherents->random(50) as $adherent) {
            Document::factory()
                ->count(rand(1, 3))
                ->create([
                    'type_documentable' => 'App\\Models\\Adherent',
                    'id_documentable' => $adherent->id,
                ]);
            $documentsCount += rand(1, 3);
        }

        $this->command->info("   ✓ {$documentsCount} documents créés");

        // Résumé final
        $this->command->newLine();
        $this->command->info('📊 Résumé des données générées:');
        $this->command->table(
            ['Type', 'Quantité'],
            [
                ['Adhérents', $adherents->count()],
                ['Adhésions', $adhesionsCount],
                ['Certificats médicaux', $certificatsCount],
                ['Certifications', $certificationsCount],
                ['Matériel', $materielCount],
                ['Séances entraînement', $seances->count()],
                ['Programmes', $programmes->count()],
                ['Sorties', $sorties->count()],
                ['Compétitions', $competitions->count()],
                ['Documents', $documentsCount],
            ]
        );

        $this->command->newLine();
        $this->command->info('🎉 Données de test générées avec succès!');
    }
}
