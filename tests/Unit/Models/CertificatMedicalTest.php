<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\CertificatMedical;
use App\Models\Adherent;
use Carbon\Carbon;

class CertificatMedicalTest extends TestCase
{
    /**
     * Test 1: Vérifier qu'un certificat médical peut être créé
     * @test
     */
    public function test_certificat_medical_can_be_created()
    {
        $adherent = Adherent::factory()->create();

        $cert = CertificatMedical::factory()->create([
            'adherent_id' => $adherent->id,
            'nom_medecin' => 'Dr. Dupont',
            'statut' => 'valide',
        ]);

        $this->assertNotNull($cert->id);
        $this->assertEquals('Dr. Dupont', $cert->nom_medecin);
        $this->assertEquals('valide', $cert->statut);
        $this->assertEquals($adherent->id, $cert->adherent_id);
    }

    /**
     * Test 2: Vérifier que les données de santé sont chiffrées (RGPD Article 9)
     * @test
     */
    public function test_health_data_is_encrypted_rgpd_article_9()
    {
        $cert = CertificatMedical::factory()->create([
            'nom_medecin' => 'Dr. Secret',
            'numero_ordre_medecin' => '12345',
            'restrictions' => 'Aucune plongée',
        ]);

        // Vérifier que les données sensibles sont chiffrées en base
        $rawData = \DB::table('certificats_medicaux')->where('id', $cert->id)->first();

        $this->assertTrue(str_starts_with($rawData->nom_medecin, 'eyJpdiI6'));
        $this->assertTrue(str_starts_with($rawData->numero_ordre_medecin, 'eyJpdiI6'));
        $this->assertTrue(str_starts_with($rawData->restrictions, 'eyJpdiI6'));
    }

    /**
     * Test 3: Vérifier la relation avec Adherent
     * @test
     */
    public function test_certificat_medical_belongs_to_adherent()
    {
        $adherent = Adherent::factory()->create();
        $cert = CertificatMedical::factory()->create(['adherent_id' => $adherent->id]);

        $this->assertInstanceOf(Adherent::class, $cert->adherent);
        $this->assertEquals($adherent->id, $cert->adherent->id);
    }

    /**
     * Test 4: Vérifier que estValide() retourne true pour un certificat valide
     * @test
     */
    public function test_est_valide_returns_true_for_future_expiry()
    {
        $futureDate = now()->addMonths(3);
        $cert = CertificatMedical::factory()->create(['expire_le' => $futureDate]);

        $this->assertTrue($cert->estValide());
    }

    /**
     * Test 5: Vérifier que estValide() retourne false pour un certificat expiré
     * @test
     */
    public function test_est_valide_returns_false_for_past_expiry()
    {
        $pastDate = now()->subMonths(1);
        $cert = CertificatMedical::factory()->create(['expire_le' => $pastDate]);

        $this->assertFalse($cert->estValide());
    }

    /**
     * Test 6: Vérifier que expireBientot() détecte les certificats expirant dans 30 jours
     * @test
     */
    public function test_expire_bientot_detects_certificates_expiring_soon()
    {
        $soon = now()->addDays(15);
        $cert = CertificatMedical::factory()->create(['expire_le' => $soon]);

        $this->assertTrue($cert->expireBientot(30));
    }

    /**
     * Test 7: Vérifier que le scope 'valide' retourne uniquement les certificats valides
     * @test
     */
    public function test_scope_valide_returns_only_valid_certificates()
    {
        $valid = CertificatMedical::factory()->create(['expire_le' => now()->addMonths(3)]);
        $expired = CertificatMedical::factory()->create(['expire_le' => now()->subMonths(1)]);

        $result = CertificatMedical::valide()->get();

        $this->assertContains($valid->id, $result->pluck('id'));
        $this->assertNotContains($expired->id, $result->pluck('id'));
    }

    /**
     * Test 8: Vérifier que le scope 'expire' retourne uniquement les certificats expirés
     * @test
     */
    public function test_scope_expire_returns_only_expired_certificates()
    {
        $valid = CertificatMedical::factory()->create(['expire_le' => now()->addMonths(3)]);
        $expired = CertificatMedical::factory()->create(['expire_le' => now()->subMonths(1)]);

        $result = CertificatMedical::expire()->get();

        $this->assertNotContains($valid->id, $result->pluck('id'));
        $this->assertContains($expired->id, $result->pluck('id'));
    }
}
