<?php

namespace Tests\Unit\Models;

use App\Models\Adherent;
use App\Models\Adhesion;
use App\Models\Saison;
use Tests\TestCase;

class AdhesionTest extends TestCase
{
    private $saison;

    private $adherent;

    protected function setUp(): void
    {
        parent::setUp();
        // Créer une saison réutilisable pour tous les tests
        $this->saison = Saison::factory()->create([
            'nom' => '2024-2025-test-'.uniqid(),
        ]);
        $this->adherent = Adherent::factory()->create();
    }

    /**
     * Test 1: Vérifier qu'une adhésion peut être créée
     *
     * @test
     */
    public function test_adhesion_can_be_created()
    {
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $this->adherent->id,
            'saison_id' => $this->saison->id,
        ]);

        $this->assertNotNull($adhesion->id);
        $this->assertEquals($this->adherent->id, $adhesion->adherent_id);
        $this->assertEquals($this->saison->id, $adhesion->saison_id);
        $this->assertIsNumeric($adhesion->montant_attendu);
    }

    /**
     * Test 2: Vérifier que le statut peut être défini à 'valide'
     *
     * @test
     */
    public function test_adhesion_status_can_be_set_to_valide()
    {
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $this->adherent->id,
            'saison_id' => $this->saison->id,
            'statut' => 'valide',
        ]);

        $this->assertEquals('valide', $adhesion->statut);
    }

    /**
     * Test 3: Vérifier que le montant_paye par défaut est 0.00
     *
     * @test
     */
    public function test_adhesion_default_payment_is_zero()
    {
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $this->adherent->id,
            'saison_id' => $this->saison->id,
            'montant_paye' => 0,
        ]);

        $this->assertEquals(0.00, $adhesion->montant_paye);
    }

    /**
     * Test 4: Vérifier que montant_attendu est requis
     *
     * @test
     */
    public function test_adhesion_montant_attendu_is_required()
    {
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $this->adherent->id,
            'saison_id' => $this->saison->id,
            'montant_attendu' => 250.50,
        ]);

        $this->assertIsNumeric($adhesion->montant_attendu);
        $this->assertEquals(250.50, $adhesion->montant_attendu);
    }

    /**
     * Test 5: Vérifier que le numéro de reçu doit être unique
     *
     * @test
     */
    public function test_adhesion_receipt_number_must_be_unique()
    {
        $numeroRecu = 'REC-2025-'.uniqid();

        Adhesion::factory()->create([
            'adherent_id' => $this->adherent->id,
            'saison_id' => $this->saison->id,
            'numero_recu' => $numeroRecu,
            'statut' => 'valide',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $adherent2 = Adherent::factory()->create();
        Adhesion::factory()->create([
            'adherent_id' => $adherent2->id,
            'saison_id' => $this->saison->id,
            'numero_recu' => $numeroRecu,
            'statut' => 'valide',
        ]);
    }

    /**
     * Test 6: Vérifier que valide_le est null pour une adhésion non validée
     *
     * @test
     */
    public function test_adhesion_valide_le_is_null_when_not_validated()
    {
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $this->adherent->id,
            'saison_id' => $this->saison->id,
            'statut' => 'en_attente',
            'valide_le' => null,
        ]);

        $this->assertNull($adhesion->valide_le);
    }
}
