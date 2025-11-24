<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\RepresentantLegal;
use App\Models\Adherent;

class RepresentantLegalTest extends TestCase
{
    /**
     * Test 1: Vérifier qu'un représentant légal peut être créé
     * @test
     */
    public function test_representant_legal_can_be_created()
    {
        $minor = Adherent::factory()->create(['est_mineur' => true]);

        $repr = RepresentantLegal::factory()->create([
            'adherent_mineur_id' => $minor->id,
            'nom' => 'Martin',
            'prenom' => 'Marie',
            'lien_parente' => 'Mère',
        ]);

        $this->assertNotNull($repr->id);
        $this->assertEquals('Martin', $repr->nom);
        $this->assertEquals('Marie', $repr->prenom);
        $this->assertEquals($minor->id, $repr->adherent_mineur_id);
    }

    /**
     * Test 2: Vérifier que le représentant légal utilise le trait EncryptsAttributes
     * @test
     */
    public function test_representant_legal_encrypts_sensitive_attributes()
    {
        $repr = RepresentantLegal::factory()->create([
            'nom' => 'Secret',
            'mobile' => '0612345678',
        ]);

        // Vérifier que le nom est chiffré en base
        $rawData = \DB::table('representants_legaux')->where('id', $repr->id)->first();
        $this->assertTrue(str_starts_with($rawData->nom, 'eyJpdiI6'));

        // Vérifier que le mobile est chiffré en base
        $this->assertTrue(str_starts_with($rawData->mobile, 'eyJpdiI6'));
    }

    /**
     * Test 3: Vérifier la relation avec Adherent
     * @test
     */
    public function test_representant_legal_belongs_to_adherent()
    {
        $minor = Adherent::factory()->create();
        $repr = RepresentantLegal::factory()->create(['adherent_mineur_id' => $minor->id]);

        $this->assertInstanceOf(Adherent::class, $repr->adherentMineur);
        $this->assertEquals($minor->id, $repr->adherentMineur->id);
    }

    /**
     * Test 4: Vérifier que le scope 'principal' retourne uniquement les représentants principaux
     * @test
     */
    public function test_scope_principal_returns_only_principal_representatives()
    {
        $principal = RepresentantLegal::factory()->create(['est_principal' => true]);
        $secondary = RepresentantLegal::factory()->create(['est_principal' => false]);

        $result = RepresentantLegal::principal()->get();

        $this->assertContains($principal->id, $result->pluck('id'));
        $this->assertNotContains($secondary->id, $result->pluck('id'));
    }

    /**
     * Test 5: Vérifier que estPrincipal() fonctionne correctement
     * @test
     */
    public function test_est_principal_method_returns_correct_value()
    {
        $principal = RepresentantLegal::factory()->create(['est_principal' => true]);
        $secondary = RepresentantLegal::factory()->create(['est_principal' => false]);

        $this->assertTrue($principal->estPrincipal());
        $this->assertFalse($secondary->estPrincipal());
    }

    /**
     * Test 6: Vérifier que peutRecuperer() fonctionne correctement
     * @test
     */
    public function test_peut_recuperer_method_returns_correct_value()
    {
        $canPickup = RepresentantLegal::factory()->create(['peut_recuperer' => true]);
        $cannotPickup = RepresentantLegal::factory()->create(['peut_recuperer' => false]);

        $this->assertTrue($canPickup->peutRecuperer());
        $this->assertFalse($cannotPickup->peutRecuperer());
    }

    /**
     * Test 7: Vérifier que autoriseSortie() fonctionne correctement
     * @test
     */
    public function test_autorise_sortie_method_returns_correct_value()
    {
        $authorized = RepresentantLegal::factory()->create(['autorise_sortie' => true]);
        $notAuthorized = RepresentantLegal::factory()->create(['autorise_sortie' => false]);

        $this->assertTrue($authorized->autoriseSortie());
        $this->assertFalse($notAuthorized->autoriseSortie());
    }

    /**
     * Test 8: Vérifier que autoriseTransport() fonctionne correctement
     * @test
     */
    public function test_autorise_transport_method_returns_correct_value()
    {
        $authorized = RepresentantLegal::factory()->create(['autorise_transport' => true]);
        $notAuthorized = RepresentantLegal::factory()->create(['autorise_transport' => false]);

        $this->assertTrue($authorized->autoriseTransport());
        $this->assertFalse($notAuthorized->autoriseTransport());
    }

    /**
     * Test 9: Vérifier que getNomCompletAttribute() retourne le nom complet
     * @test
     */
    public function test_get_nom_complet_attribute_returns_full_name()
    {
        $repr = RepresentantLegal::factory()->create([
            'civilite' => 'Mme',
            'prenom' => 'Marie',
            'nom' => 'Martin',
        ]);

        $this->assertEquals('Mme Marie Martin', $repr->nom_complet);
    }

    /**
     * Test 10: Vérifier que getAdresseCompleteAttribute() retourne l'adresse complète
     * @test
     */
    public function test_get_adresse_complete_attribute_returns_full_address()
    {
        $repr = RepresentantLegal::factory()->create([
            'numero_rue' => '123',
            'rue' => 'Rue du Commerce',
            'complement_adresse' => 'Bureau 2',
            'code_postal' => '69100',
            'ville' => 'Villeurbanne',
            'pays' => 'France',
        ]);

        $address = $repr->adresse_complete;

        $this->assertStringContainsString('123', $address);
        $this->assertStringContainsString('Rue du Commerce', $address);
        $this->assertStringContainsString('Bureau 2', $address);
        $this->assertStringContainsString('69100', $address);
        $this->assertStringContainsString('Villeurbanne', $address);
    }
}
