<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Competition;
use App\Models\Saison;

class CompetitionTest extends TestCase
{
    private $saison;

    public function setUp(): void
    {
        parent::setUp();
        // Créer une saison réutilisable pour tous les tests
        $this->saison = Saison::factory()->create([
            'nom' => '2024-2025-comp-' . uniqid(),
        ]);
    }

    /**
     * Test 1: Vérifier qu'une compétition peut être créée
     * @test
     */
    public function test_competition_can_be_created()
    {
        $competition = Competition::factory()->create([
            'saison_id' => $this->saison->id,
        ]);

        $this->assertNotNull($competition->id);
        $this->assertEquals($this->saison->id, $competition->saison_id);
        $this->assertNotNull($competition->titre);
        $this->assertNotNull($competition->date_competition);
    }

    /**
     * Test 2: Vérifier que est_regionale est true pour les compétitions régionales
     * @test
     */
    public function test_competition_regional_flag_is_set()
    {
        $competition = Competition::factory()->create([
            'saison_id' => $this->saison->id,
            'est_regionale' => true,
            'est_nationale' => false,
        ]);

        $this->assertTrue($competition->est_regionale);
        $this->assertFalse($competition->est_nationale);
    }

    /**
     * Test 3: Vérifier que est_nationale est true pour les compétitions nationales
     * @test
     */
    public function test_competition_national_flag_is_set()
    {
        $competition = Competition::factory()->create([
            'saison_id' => $this->saison->id,
            'est_regionale' => false,
            'est_nationale' => true,
        ]);

        $this->assertFalse($competition->est_regionale);
        $this->assertTrue($competition->est_nationale);
    }

    /**
     * Test 4: Vérifier que necesssite_hebergement peut être true
     * @test
     */
    public function test_competition_can_require_accommodation()
    {
        $competition = Competition::factory()->create([
            'saison_id' => $this->saison->id,
            'necessite_hebergement' => true,
        ]);

        $this->assertTrue($competition->necessite_hebergement);
    }

    /**
     * Test 5: Vérifier que participants_max peut être null
     * @test
     */
    public function test_competition_max_participants_can_be_null()
    {
        $competition = Competition::factory()->create([
            'saison_id' => $this->saison->id,
            'participants_max' => null,
        ]);

        $this->assertNull($competition->participants_max);
    }
}
