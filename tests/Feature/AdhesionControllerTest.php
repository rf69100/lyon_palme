<?php

namespace Tests\Feature;

use App\Models\Adherent;
use App\Models\Adhesion;
use App\Models\Paiement;
use App\Models\Saison;
use App\Models\TypeAdhesion;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdhesionControllerTest extends TestCase
{
    use RefreshDatabase;

    private Utilisateur $utilisateur;

    protected function setUp(): void
    {
        parent::setUp();

        $this->utilisateur = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $this->grantAdminRole($this->utilisateur);
    }

    /**
     * Test que la liste des cotisations est affichée.
     */
    public function test_liste_cotisations_affichee(): void
    {
        $adherent = Adherent::factory()->create();
        $saison = Saison::factory()->create(['nom' => 'test-saison-'.uniqid()]);
        $typeAdhesion = TypeAdhesion::factory()->create();

        Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => $saison->id,
            'type_adhesion_id' => $typeAdhesion->id,
        ]);

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.cotisations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.cotisations.index');
        $response->assertViewHas('adhesions');
    }

    /**
     * Test que les utilisateurs non authentifiés sont redirigés.
     */
    public function test_utilisateur_non_authentifie_redirige(): void
    {
        $response = $this->get(route('admin.cotisations.index'));

        $response->assertRedirect('/login');
    }

    /**
     * Test du calcul du statut paiement "a_jour".
     */
    public function test_calcul_statut_paiement_a_jour(): void
    {
        $adherent = Adherent::factory()->create();
        $saison = Saison::factory()->create(['nom' => 'test-saison-'.uniqid()]);

        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => $saison->id,
            'montant_attendu' => 200,
            'montant_paye' => 200,
        ]);

        $this->assertEquals('a_jour', $adhesion->statut_paiement);
    }

    /**
     * Test du calcul du statut paiement "partiel".
     */
    public function test_calcul_statut_paiement_partiel(): void
    {
        $adherent = Adherent::factory()->create();
        $saison = Saison::factory()->create(['nom' => 'test-saison-'.uniqid()]);

        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => $saison->id,
            'montant_attendu' => 200,
            'montant_paye' => 100,
        ]);

        $this->assertEquals('partiel', $adhesion->statut_paiement);
    }

    /**
     * Test du calcul du statut paiement "impaye".
     */
    public function test_calcul_statut_paiement_impaye(): void
    {
        $adherent = Adherent::factory()->create();
        $saison = Saison::factory()->create(['nom' => 'test-saison-'.uniqid()]);

        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => $saison->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $this->assertEquals('impaye', $adhesion->statut_paiement);
    }

    /**
     * Test du filtre par saison.
     */
    public function test_filtre_par_saison(): void
    {
        $adherent = Adherent::factory()->create();
        $saison1 = Saison::factory()->create(['nom' => 'test-saison1-'.uniqid()]);
        $saison2 = Saison::factory()->create(['nom' => 'test-saison2-'.uniqid()]);

        $adhesion1 = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => $saison1->id,
        ]);

        $adhesion2 = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => $saison2->id,
        ]);

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.cotisations.index', ['saison_id' => $saison1->id]));

        $response->assertStatus(200);
        $adhesions = $response->viewData('adhesions');
        $ids = $adhesions->pluck('id')->toArray();

        $this->assertContains($adhesion1->id, $ids);
        $this->assertNotContains($adhesion2->id, $ids);
    }

    /**
     * Test du filtre par statut "impayes".
     */
    public function test_filtre_par_statut_impayes(): void
    {
        $adherent = Adherent::factory()->create();
        $saison = Saison::factory()->create(['nom' => 'test-saison-'.uniqid()]);

        $adhesionImpayee = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => $saison->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $adhesionPayee = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison2-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 200,
        ]);

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.cotisations.index', ['statut_paiement' => 'impayes']));

        $response->assertStatus(200);
        $adhesions = $response->viewData('adhesions');
        $ids = $adhesions->pluck('id')->toArray();

        $this->assertContains($adhesionImpayee->id, $ids);
        $this->assertNotContains($adhesionPayee->id, $ids);
    }

    /**
     * Test du filtre par statut "a_jour".
     */
    public function test_filtre_par_statut_a_jour(): void
    {
        $adherent = Adherent::factory()->create();

        $adhesionPayee = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison1-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 200,
        ]);

        $adhesionImpayee = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison2-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.cotisations.index', ['statut_paiement' => 'a_jour']));

        $response->assertStatus(200);
        $adhesions = $response->viewData('adhesions');
        $ids = $adhesions->pluck('id')->toArray();

        $this->assertContains($adhesionPayee->id, $ids);
        $this->assertNotContains($adhesionImpayee->id, $ids);
    }

    /**
     * Test de l'export Excel.
     */
    public function test_export_excel(): void
    {
        $adherent = Adherent::factory()->create();
        Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
        ]);

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.cotisations.export'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * Test de la pagination.
     */
    public function test_pagination_fonctionne(): void
    {
        $adherent = Adherent::factory()->create();

        // Créer 25 adhésions
        for ($i = 0; $i < 25; $i++) {
            Adhesion::factory()->create([
                'adherent_id' => $adherent->id,
                'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            ]);
        }

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.cotisations.index'));

        $response->assertStatus(200);
        $adhesions = $response->viewData('adhesions');

        $this->assertLessThanOrEqual(20, $adhesions->count());
        $this->assertGreaterThanOrEqual(25, $adhesions->total());
    }

    /**
     * Test que la vue contient les éléments requis.
     */
    public function test_vue_contient_elements_requis(): void
    {
        $adherent = Adherent::factory()->create();
        Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
        ]);

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.cotisations.index'));

        $response->assertStatus(200);
        $response->assertSee('Cotisations et Paiements');
        $response->assertSee('Filtrer');
        $response->assertSee('Exporter Excel');
    }
}
