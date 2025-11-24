<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Adherent;
use App\Models\Utilisateur;
use App\Models\RepresentantLegal;
use App\Models\Adhesion;

class AdherentTest extends TestCase
{
    /**
     * Test 1: Vérifier qu'un adhérent peut être créé
     * @test
     */
    public function test_adherent_can_be_created()
    {
        $adherent = Adherent::factory()->create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'dupont.jean.' . uniqid() . '@example.com',
        ]);

        $this->assertNotNull($adherent->id);
        $this->assertEquals('Dupont', $adherent->nom);
        $this->assertEquals('Jean', $adherent->prenom);
    }

    /**
     * Test 2: Vérifier que l'adhérent utilise le trait EncryptsAttributes
     * @test
     */
    public function test_adherent_encrypts_sensitive_attributes()
    {
        $adherent = Adherent::factory()->create([
            'nom' => 'Secret',
            'email' => 'secret.' . uniqid() . '@example.com',
        ]);

        // Vérifier que le nom est chiffré en base
        $rawData = \DB::table('adherents')->where('id', $adherent->id)->first();
        $this->assertTrue(str_starts_with($rawData->nom, 'eyJpdiI6'));
    }

    /**
     * Test 3: Vérifier que le scope 'actif' retourne uniquement les adhérents actifs
     * @test
     */
    public function test_scope_actif_returns_only_active_adherents()
    {
        $active = Adherent::factory()->create(['statut' => 'actif']);
        $archived = Adherent::factory()->create(['statut' => 'archive']);

        $result = Adherent::actif()->get();

        $this->assertContains($active->id, $result->pluck('id'));
        $this->assertNotContains($archived->id, $result->pluck('id'));
    }

    /**
     * Test 4: Vérifier que le scope 'archive' retourne uniquement les adhérents archivés
     * @test
     */
    public function test_scope_archive_returns_only_archived_adherents()
    {
        $active = Adherent::factory()->create(['statut' => 'actif']);
        $archived = Adherent::factory()->create(['statut' => 'archive']);

        $result = Adherent::archive()->get();

        $this->assertNotContains($active->id, $result->pluck('id'));
        $this->assertContains($archived->id, $result->pluck('id'));
    }

    /**
     * Test 5: Vérifier que le scope 'mineur' retourne uniquement les mineurs
     * @test
     */
    public function test_scope_mineur_returns_only_minors()
    {
        $minor = Adherent::factory()->create(['est_mineur' => true]);
        $adult = Adherent::factory()->create(['est_mineur' => false]);

        $result = Adherent::mineur()->get();

        $this->assertContains($minor->id, $result->pluck('id'));
        $this->assertNotContains($adult->id, $result->pluck('id'));
    }

    /**
     * Test 6: Vérifier que le scope 'majeur' retourne uniquement les majeurs
     * @test
     */
    public function test_scope_majeur_returns_only_adults()
    {
        $minor = Adherent::factory()->create(['est_mineur' => true]);
        $adult = Adherent::factory()->create(['est_mineur' => false]);

        $result = Adherent::majeur()->get();

        $this->assertNotContains($minor->id, $result->pluck('id'));
        $this->assertContains($adult->id, $result->pluck('id'));
    }

    /**
     * Test 7: Vérifier que la méthode estMineur() fonctionne correctement
     * @test
     */
    public function test_est_mineur_method_returns_correct_value()
    {
        $minor = Adherent::factory()->create(['est_mineur' => true]);
        $adult = Adherent::factory()->create(['est_mineur' => false]);

        $this->assertTrue($minor->estMineur());
        $this->assertFalse($adult->estMineur());
    }

    /**
     * Test 8: Vérifier que la méthode estActif() fonctionne correctement
     * @test
     */
    public function test_est_actif_method_returns_correct_value()
    {
        $active = Adherent::factory()->create(['statut' => 'actif']);
        $archived = Adherent::factory()->create(['statut' => 'archive']);

        $this->assertTrue($active->estActif());
        $this->assertFalse($archived->estActif());
    }

    /**
     * Test 9: Vérifier que la méthode archiver() change le statut et la date
     * @test
     */
    public function test_archiver_method_sets_status_and_date()
    {
        $adherent = Adherent::factory()->create(['statut' => 'actif', 'archive_le' => null]);

        $adherent->archiver();

        $updated = Adherent::find($adherent->id);

        $this->assertEquals('archive', $updated->statut);
        $this->assertNotNull($updated->archive_le);
    }

    /**
     * Test 10: Vérifier que la méthode reactiver() réactive un adhérent archivé
     * @test
     */
    public function test_reactiver_method_reactivates_archived_adherent()
    {
        $adherent = Adherent::factory()->create(['statut' => 'archive', 'archive_le' => now()]);

        $adherent->reactiver();

        $updated = Adherent::find($adherent->id);

        $this->assertEquals('actif', $updated->statut);
        $this->assertNull($updated->archive_le);
    }

    /**
     * Test 11: Vérifier que getNomCompletAttribute() retourne le nom complet
     * @test
     */
    public function test_get_nom_complet_attribute_returns_full_name()
    {
        $adherent = Adherent::factory()->create([
            'civilite' => 'M.',
            'prenom' => 'Jean',
            'nom' => 'Dupont',
        ]);

        $this->assertEquals('M. Jean Dupont', $adherent->nom_complet);
    }

    /**
     * Test 12: Vérifier que getAdresseCompleteAttribute() retourne l'adresse complète
     * @test
     */
    public function test_get_adresse_complete_attribute_returns_full_address()
    {
        $adherent = Adherent::factory()->create([
            'numero_rue' => '42',
            'rue' => 'Rue de la Paix',
            'complement_adresse' => 'Apt 5',
            'code_postal' => '69000',
            'ville' => 'Lyon',
            'pays' => 'France',
        ]);

        $address = $adherent->adresse_complete;

        $this->assertStringContainsString('42', $address);
        $this->assertStringContainsString('Rue de la Paix', $address);
        $this->assertStringContainsString('Apt 5', $address);
        $this->assertStringContainsString('69000', $address);
        $this->assertStringContainsString('Lyon', $address);
    }

    /**
     * Test 13: Vérifier la recherche par nom via rechercherParNom()
     * @test
     */
    public function test_rechercher_par_nom_finds_adherent()
    {
        $adherent = Adherent::factory()->create(['nom' => 'Recherche']);

        $results = Adherent::rechercherParNom('Recherche');

        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertContains($adherent->id, $results->pluck('id'));
    }

    /**
     * Test 14: Vérifier la recherche par prénom via rechercherParPrenom()
     * @test
     */
    public function test_rechercher_par_prenom_finds_adherent()
    {
        $adherent = Adherent::factory()->create(['prenom' => 'Unique' . uniqid()]);

        $results = Adherent::rechercherParPrenom($adherent->prenom);

        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertContains($adherent->id, $results->pluck('id'));
    }

    /**
     * Test 15: Vérifier la recherche par nom complet via rechercherParNomComplet()
     * @test
     */
    public function test_rechercher_par_nom_complet_finds_adherent()
    {
        $nom = 'Nom' . uniqid();
        $prenom = 'Prenom' . uniqid();
        $adherent = Adherent::factory()->create([
            'nom' => $nom,
            'prenom' => $prenom,
        ]);

        $results = Adherent::rechercherParNomComplet($nom, $prenom);

        $this->assertGreaterThanOrEqual(1, $results->count());
        $this->assertContains($adherent->id, $results->pluck('id'));
    }
}
