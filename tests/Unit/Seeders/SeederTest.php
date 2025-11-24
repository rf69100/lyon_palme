<?php

namespace Tests\Unit\Seeders;

use Tests\TestCase;
use Illuminate\Database\Seeder;
use Database\Seeders\UtilisateurSeeder;
use Database\Seeders\SaisonSeeder;
use Database\Seeders\TypeAdhesionSeeder;
use Database\Seeders\TarifSeeder;
use Database\Seeders\AdherentSeeder;
use Database\Seeders\CertificatMedicalSeeder;
use Database\Seeders\AdhesionSeeder;
use Database\Seeders\SortieSeeder;
use Database\Seeders\CompetitionSeeder;
use Database\Seeders\TypeMaterielSeeder;
use ReflectionClass;

class SeederTest extends TestCase
{
    /**
     * Test 1: Vérifier que UtilisateurSeeder existe
     * @test
     */
    public function test_utilisateur_seeder_exists()
    {
        $this->assertTrue(class_exists(UtilisateurSeeder::class));
    }

    /**
     * Test 2: Vérifier que SaisonSeeder existe
     * @test
     */
    public function test_saison_seeder_exists()
    {
        $this->assertTrue(class_exists(SaisonSeeder::class));
    }

    /**
     * Test 3: Vérifier que TypeAdhesionSeeder existe
     * @test
     */
    public function test_type_adhesion_seeder_exists()
    {
        $this->assertTrue(class_exists(TypeAdhesionSeeder::class));
    }

    /**
     * Test 4: Vérifier que TarifSeeder existe
     * @test
     */
    public function test_tarif_seeder_exists()
    {
        $this->assertTrue(class_exists(TarifSeeder::class));
    }

    /**
     * Test 5: Vérifier que AdherentSeeder existe
     * @test
     */
    public function test_adherent_seeder_exists()
    {
        $this->assertTrue(class_exists(AdherentSeeder::class));
    }

    /**
     * Test 6: Vérifier que CertificatMedicalSeeder existe
     * @test
     */
    public function test_certificat_medical_seeder_exists()
    {
        $this->assertTrue(class_exists(CertificatMedicalSeeder::class));
    }

    /**
     * Test 7: Vérifier que AdhesionSeeder existe
     * @test
     */
    public function test_adhesion_seeder_exists()
    {
        $this->assertTrue(class_exists(AdhesionSeeder::class));
    }

    /**
     * Test 8: Vérifier que SortieSeeder existe
     * @test
     */
    public function test_sortie_seeder_exists()
    {
        $this->assertTrue(class_exists(SortieSeeder::class));
    }

    /**
     * Test 9: Vérifier que CompetitionSeeder existe
     * @test
     */
    public function test_competition_seeder_exists()
    {
        $this->assertTrue(class_exists(CompetitionSeeder::class));
    }

    /**
     * Test 10: Vérifier que TypeMaterielSeeder existe
     * @test
     */
    public function test_type_materiel_seeder_exists()
    {
        $this->assertTrue(class_exists(TypeMaterielSeeder::class));
    }

    /**
     * Test 11: Vérifier que les seeders étendent Seeder
     * @test
     */
    public function test_seeders_extend_seeder_class()
    {
        $seederClasses = [
            UtilisateurSeeder::class,
            SaisonSeeder::class,
            TypeAdhesionSeeder::class,
            AdherentSeeder::class,
        ];

        foreach ($seederClasses as $seederClass) {
            $this->assertTrue(
                is_subclass_of($seederClass, \Illuminate\Database\Seeder::class),
                "$seederClass should extend Seeder"
            );
        }
    }

    /**
     * Test 12: Vérifier que les seeders ont une méthode run()
     * @test
     */
    public function test_seeders_have_run_method()
    {
        $seederClasses = [
            UtilisateurSeeder::class,
            SaisonSeeder::class,
            TypeAdhesionSeeder::class,
            AdherentSeeder::class,
        ];

        foreach ($seederClasses as $seederClass) {
            $seeder = new $seederClass();
            $this->assertTrue(
                method_exists($seeder, 'run'),
                "$seederClass should have a run() method"
            );
        }
    }

    /**
     * Test 13: Vérifier que tous les seeders sont instanciables
     * @test
     */
    public function test_all_seeders_are_instantiable()
    {
        $seederClasses = [
            UtilisateurSeeder::class,
            SaisonSeeder::class,
            TypeAdhesionSeeder::class,
            TarifSeeder::class,
            AdherentSeeder::class,
            CertificatMedicalSeeder::class,
        ];

        foreach ($seederClasses as $seederClass) {
            $reflection = new ReflectionClass($seederClass);
            $this->assertTrue(
                $reflection->isInstantiable(),
                "$seederClass should be instantiable"
            );
        }
    }

    /**
     * Test 14: Vérifier que les seeders sont dans le bon répertoire
     * @test
     */
    public function test_seeders_are_in_correct_directory()
    {
        $seederPath = database_path('seeders');
        $this->assertTrue(
            is_dir($seederPath),
            'Seeders directory should exist'
        );

        $files = scandir($seederPath);
        $this->assertGreaterThan(0, count($files));
    }

    /**
     * Test 15: Vérifier que DatabaseSeeder existe
     * @test
     */
    public function test_database_seeder_exists()
    {
        $seederPath = database_path('seeders/DatabaseSeeder.php');
        $this->assertFileExists($seederPath);
    }

    /**
     * Test 16: Vérifier que le fichier UtilisateurSeeder existe
     * @test
     */
    public function test_utilisateur_seeder_file_exists()
    {
        $seederPath = database_path('seeders/UtilisateurSeeder.php');
        $this->assertFileExists($seederPath);
    }

    /**
     * Test 17: Vérifier que le fichier SaisonSeeder existe
     * @test
     */
    public function test_saison_seeder_file_exists()
    {
        $seederPath = database_path('seeders/SaisonSeeder.php');
        $this->assertFileExists($seederPath);
    }

    /**
     * Test 18: Vérifier que le fichier AdherentSeeder existe
     * @test
     */
    public function test_adherent_seeder_file_exists()
    {
        $seederPath = database_path('seeders/AdherentSeeder.php');
        $this->assertFileExists($seederPath);
    }

    /**
     * Test 19: Vérifier que tous les seeders majeurs existent
     * @test
     */
    public function test_all_major_seeders_exist()
    {
        $requiredSeeders = [
            'UtilisateurSeeder.php',
            'SaisonSeeder.php',
            'TypeAdhesionSeeder.php',
            'TarifSeeder.php',
            'AdherentSeeder.php',
            'AdhesionSeeder.php',
            'SortieSeeder.php',
            'CompetitionSeeder.php',
        ];

        foreach ($requiredSeeders as $seederFile) {
            $seederPath = database_path("seeders/$seederFile");
            $this->assertFileExists($seederPath, "$seederFile should exist");
        }
    }

    /**
     * Test 20: Vérifier que les seeders contiennent du code
     * @test
     */
    public function test_seeders_have_implementation()
    {
        $seederClasses = [
            UtilisateurSeeder::class,
            SaisonSeeder::class,
            TypeAdhesionSeeder::class,
            AdherentSeeder::class,
        ];

        foreach ($seederClasses as $seederClass) {
            $reflection = new ReflectionClass($seederClass);
            $runMethod = $reflection->getMethod('run');
            $this->assertNotNull($runMethod, "$seederClass should have a run method");
            $this->assertTrue($runMethod->isPublic(), "run() method should be public");
        }
    }
}
