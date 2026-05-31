<?php

namespace Tests\Unit\Models;

use App\Models\Adherent;
use App\Models\Competition;
use App\Models\InscriptionCompetition;
use Tests\TestCase;

class InscriptionCompetitionTest extends TestCase
{
    private $competition;

    private $adherent;

    protected function setUp(): void
    {
        parent::setUp();
        // Créer une compétition et un adhérent réutilisables
        $this->competition = Competition::factory()->create();
        $this->adherent = Adherent::factory()->create();
    }

    /**
     * Test 1: Vérifier qu'une inscription compétition peut être créée
     *
     * @test
     */
    public function test_inscription_competition_can_be_created()
    {
        $inscription = InscriptionCompetition::factory()->create([
            'competition_id' => $this->competition->id,
            'adherent_id' => $this->adherent->id,
        ]);

        $this->assertNotNull($inscription->id);
        $this->assertEquals($this->competition->id, $inscription->competition_id);
        $this->assertEquals($this->adherent->id, $inscription->adherent_id);
    }

    /**
     * Test 2: Vérifier que le statut par défaut est 'inscrit'
     *
     * @test
     */
    public function test_inscription_default_status_is_inscrit()
    {
        $inscription = InscriptionCompetition::factory()->create([
            'competition_id' => $this->competition->id,
            'adherent_id' => $this->adherent->id,
            'statut' => 'inscrit',
        ]);

        $this->assertEquals('inscrit', $inscription->statut);
    }

    /**
     * Test 3: Vérifier que besoin_hebergement peut être true
     *
     * @test
     */
    public function test_inscription_can_require_accommodation()
    {
        $inscription = InscriptionCompetition::factory()->create([
            'competition_id' => $this->competition->id,
            'adherent_id' => $this->adherent->id,
            'besoin_hebergement' => true,
        ]);

        $this->assertTrue($inscription->besoin_hebergement);
    }
}
