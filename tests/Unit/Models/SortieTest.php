<?php

namespace Tests\Unit\Models;

use App\Models\Adherent;
use App\Models\Saison;
use App\Models\Sortie;
use Tests\TestCase;

class SortieTest extends TestCase
{
    private $saison;

    private $adherent;

    protected function setUp(): void
    {
        parent::setUp();
        // Créer une saison réutilisable pour tous les tests
        $this->saison = Saison::factory()->create([
            'nom' => '2024-2025-sortie-'.uniqid(),
        ]);
        $this->adherent = Adherent::factory()->create();
    }

    /**
     * Test 1: Vérifier qu'une sortie peut être créée
     *
     * @test
     */
    public function test_sortie_can_be_created()
    {
        $sortie = Sortie::factory()->create([
            'saison_id' => $this->saison->id,
            'organisateur_adherent_id' => $this->adherent->id,
        ]);

        $this->assertNotNull($sortie->id);
        $this->assertEquals($this->saison->id, $sortie->saison_id);
        $this->assertEquals($this->adherent->id, $sortie->organisateur_adherent_id);
        $this->assertNotNull($sortie->titre);
        $this->assertNotNull($sortie->lieu);
    }

    /**
     * Test 2: Vérifier que le statut peut être défini à 'planifie'
     *
     * @test
     */
    public function test_sortie_status_can_be_set_to_planifie()
    {
        $sortie = Sortie::factory()->create([
            'saison_id' => $this->saison->id,
            'organisateur_adherent_id' => $this->adherent->id,
            'statut' => 'planifie',
        ]);

        $this->assertEquals('planifie', $sortie->statut);
    }

    /**
     * Test 3: Vérifier que le type_sortie peut être défini à 'loisir'
     *
     * @test
     */
    public function test_sortie_type_can_be_set_to_loisir()
    {
        $sortie = Sortie::factory()->create([
            'saison_id' => $this->saison->id,
            'organisateur_adherent_id' => $this->adherent->id,
            'type_sortie' => 'loisir',
        ]);

        $this->assertEquals('loisir', $sortie->type_sortie);
    }

    /**
     * Test 4: Vérifier que le statut peut être changé à 'annule'
     *
     * @test
     */
    public function test_sortie_status_can_be_changed_to_annule()
    {
        $sortie = Sortie::factory()->create([
            'saison_id' => $this->saison->id,
            'organisateur_adherent_id' => $this->adherent->id,
            'statut' => 'annule',
            'raison_annulation' => 'Mauvaises conditions météo',
        ]);

        $this->assertEquals('annule', $sortie->statut);
        $this->assertNotNull($sortie->raison_annulation);
    }

    /**
     * Test 5: Vérifier que temperature_eau peut être null
     *
     * @test
     */
    public function test_sortie_temperature_eau_can_be_null()
    {
        $sortie = Sortie::factory()->create([
            'saison_id' => $this->saison->id,
            'organisateur_adherent_id' => $this->adherent->id,
            'temperature_eau' => null,
        ]);

        $this->assertNull($sortie->temperature_eau);
    }
}
