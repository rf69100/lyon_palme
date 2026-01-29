<?php

namespace Tests\Feature;

use App\Models\Adherent;
use App\Models\Adhesion;
use App\Models\Paiement;
use App\Models\Saison;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaiementControllerTest extends TestCase
{
    use RefreshDatabase;

    private Utilisateur $utilisateur;

    protected function setUp(): void
    {
        parent::setUp();

        $this->utilisateur = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);
    }

    /**
     * Helper to make authenticated POST requests without CSRF.
     */
    protected function postWithoutCsrf(string $route, array $data = []): \Illuminate\Testing\TestResponse
    {
        // Set a known token in the session and request
        $token = 'test-csrf-token';
        session(['_token' => $token]);

        return $this->actingAs($this->utilisateur)
            ->withSession(['_token' => $token])
            ->post($route, array_merge($data, ['_token' => $token]));
    }

    /**
     * Test que le formulaire d'ajout de paiement s'affiche.
     */
    public function test_formulaire_ajout_paiement_affiche(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->actingAs($this->utilisateur)
            ->get(route('admin.paiements.create', $adhesion));

        $response->assertStatus(200);
        $response->assertViewIs('admin.paiements.create');
        $response->assertViewHas('adhesion');
        $response->assertSee('Ajouter un paiement');
    }

    /**
     * Test de l'ajout d'un paiement valide.
     */
    public function test_ajout_paiement_valide(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => 100,
            'moyen_paiement' => 'cheque',
            'date_paiement' => now()->format('Y-m-d'),
            'numero_recu' => 'REC-2025-001',
            'remarques' => 'Test paiement',
        ]);

        $response->assertRedirect(route('admin.cotisations.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('paiements', [
            'adhesion_id' => $adhesion->id,
            'montant' => 100,
            'moyen_paiement' => 'cheque',
        ]);
    }

    /**
     * Test qu'un montant supérieur au solde est refusé.
     */
    public function test_montant_superieur_solde_refuse(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 150,
        ]);

        // Le solde est 50€, essayons de payer 100€
        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => 100,
            'moyen_paiement' => 'cheque',
            'date_paiement' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('montant');
    }

    /**
     * Test qu'un montant négatif est refusé.
     */
    public function test_montant_negatif_refuse(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => -50,
            'moyen_paiement' => 'cheque',
            'date_paiement' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('montant');
    }

    /**
     * Test qu'un montant de zéro est refusé.
     */
    public function test_montant_zero_refuse(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => 0,
            'moyen_paiement' => 'cheque',
            'date_paiement' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('montant');
    }

    /**
     * Test du recalcul automatique du solde après paiement.
     */
    public function test_recalcul_automatique_solde(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => 75,
            'moyen_paiement' => 'especes',
            'date_paiement' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect();

        $adhesion->refresh();

        $this->assertEquals(75, (float) $adhesion->montant_paye);
        $this->assertEquals(125, (float) $adhesion->solde);
    }

    /**
     * Test de la trace dans audit_logs.
     */
    public function test_trace_audit_logs(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => 100,
            'moyen_paiement' => 'virement',
            'date_paiement' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'create',
            'resource_type' => 'Paiement',
        ]);
    }

    /**
     * Test qu'une date de paiement dans le futur est refusée.
     */
    public function test_date_paiement_future_refusee(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => 100,
            'moyen_paiement' => 'cheque',
            'date_paiement' => now()->addDays(5)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('date_paiement');
    }

    /**
     * Test qu'un mode de paiement invalide est refusé.
     */
    public function test_mode_paiement_invalide_refuse(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
            'montant' => 100,
            'moyen_paiement' => 'bitcoin',
            'date_paiement' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('moyen_paiement');
    }

    /**
     * Test que les champs obligatoires sont requis.
     */
    public function test_champs_obligatoires_requis(): void
    {
        $adherent = Adherent::factory()->create();
        $adhesion = Adhesion::factory()->create([
            'adherent_id' => $adherent->id,
            'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
            'montant_attendu' => 200,
            'montant_paye' => 0,
        ]);

        $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), []);

        $response->assertSessionHasErrors(['montant', 'moyen_paiement', 'date_paiement']);
    }

    /**
     * Test que le paiement peut être fait avec tous les modes valides.
     */
    public function test_tous_modes_paiement_valides(): void
    {
        $modes = ['especes', 'cheque', 'virement', 'carte_bancaire', 'helloasso'];

        foreach ($modes as $mode) {
            $adherent = Adherent::factory()->create();
            $adhesion = Adhesion::factory()->create([
                'adherent_id' => $adherent->id,
                'saison_id' => Saison::factory()->create(['nom' => 'test-saison-'.uniqid()])->id,
                'montant_attendu' => 200,
                'montant_paye' => 0,
            ]);

            $response = $this->postWithoutCsrf(route('admin.paiements.store', $adhesion), [
                'montant' => 50,
                'moyen_paiement' => $mode,
                'date_paiement' => now()->format('Y-m-d'),
            ]);

            $response->assertRedirect(route('admin.cotisations.index'));

            $this->assertDatabaseHas('paiements', [
                'adhesion_id' => $adhesion->id,
                'moyen_paiement' => $mode,
            ]);
        }
    }
}
