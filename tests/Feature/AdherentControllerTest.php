<?php

use App\Models\Adherent;
use App\Models\AdherentRole;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/** Récupère l'id de l'adhérent depuis l'URL de redirection (show). */
function adherentIdFromRedirect($response): int
{
    return (int) basename(parse_url($response->headers->get('Location'), PHP_URL_PATH));
}

uses(RefreshDatabase::class);

beforeEach(function () {
    // Créer un utilisateur administrateur pour les tests
    $this->admin = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    $this->adherentAdmin = Adherent::factory()->create([
        'utilisateur_id' => $this->admin->id,
        'statut' => 'actif',
    ]);

    // Créer le rôle secrétaire et l'assigner
    $roleSecretaire = Role::firstOrCreate(
        ['nom' => Role::SECRETAIRE],
        ['nom_affichage' => 'Secrétaire', 'description' => 'Secrétaire du club']
    );

    AdherentRole::create([
        'adherent_id' => $this->adherentAdmin->id,
        'role_id' => $roleSecretaire->id,
        'attribue_le' => now(),
        'est_actif' => true,
    ]);
});

test('index page requires authentication', function () {
    $response = $this->get(route('admin.adherents.index'));

    $response->assertRedirect(route('login'));
});

test('index page requires admin role', function () {
    $user = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    $adherent = Adherent::factory()->create(['utilisateur_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('admin.adherents.index'));

    $response->assertForbidden();
});

test('admin can access index page', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.adherents.index'));

    $response->assertSuccessful();
    $response->assertViewIs('admin.adherents.index');
    $response->assertViewHas('adherents');
});

test('index page displays adherents', function () {
    Adherent::factory()->count(3)->create();

    $response = $this->actingAs($this->admin)->get(route('admin.adherents.index'));

    $response->assertSuccessful();
    $response->assertSee('Gestion des Adhérents', false);
});

test('index page can filter by status', function () {
    $actif = Adherent::factory()->create(['statut' => 'actif']);
    $archive = Adherent::factory()->create(['statut' => 'archive']);

    $response = $this->actingAs($this->admin)->get(route('admin.adherents.index', ['statut' => 'actif']));

    $response->assertSuccessful();
});

test('index page can search by encrypted name', function () {
    $cible = Adherent::factory()->create(['nom' => 'Zorglubsearch', 'prenom' => 'Aurelie', 'statut' => 'actif']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.adherents.index', ['search' => 'Zorglubsearch']));

    $response->assertSuccessful();
    $response->assertViewHas('adherents', function ($adherents) use ($cible) {
        return $adherents->contains('id', $cible->id);
    });
});

test('create page requires authentication', function () {
    $response = $this->get(route('admin.adherents.create'));

    $response->assertRedirect(route('login'));
});

test('admin can access create page', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.adherents.create'));

    $response->assertSuccessful();
    $response->assertViewIs('admin.adherents.create');
});

test('admin can create new adherent', function () {
    $data = [
        'civilite' => 'M.',
        'prenom' => 'Jean',
        'nom' => 'Dupont',
        'date_naissance' => '1990-01-01',
        'email' => 'jean.dupont@example.com',
        'telephone' => '0123456789',
        'statut' => 'actif',
        'consentement_rgpd' => '1',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);

    $response->assertRedirect();

    // Le store redirige vers admin.adherents.show/{id} : on cible l'adhérent
    // précisément créé (la base de test n'est pas isolée) et on vérifie les
    // valeurs déchiffrées par les accesseurs du modèle (colonnes chiffrées).
    $id = (int) basename(parse_url($response->headers->get('Location'), PHP_URL_PATH));
    $adherent = Adherent::findOrFail($id);
    expect($adherent->prenom)->toBe('Jean');
    expect($adherent->nom)->toBe('Dupont');
    expect($adherent->statut)->toBe('actif');
});

test('store validates required fields', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), []);

    $response->assertSessionHasErrors(['civilite', 'prenom', 'nom', 'date_naissance', 'statut']);
});

test('store validates civilite values', function () {
    $data = [
        'civilite' => 'Invalid',
        'prenom' => 'Jean',
        'nom' => 'Dupont',
        'date_naissance' => '1990-01-01',
        'statut' => 'actif',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);

    $response->assertSessionHasErrors('civilite');
});

test('store validates date_naissance is before today', function () {
    $data = [
        'civilite' => 'M.',
        'prenom' => 'Jean',
        'nom' => 'Dupont',
        'date_naissance' => now()->addDay()->format('Y-m-d'),
        'statut' => 'actif',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);

    $response->assertSessionHasErrors('date_naissance');
});

test('show page displays adherent details', function () {
    $adherent = Adherent::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.adherents.show', $adherent));

    $response->assertSuccessful();
    $response->assertViewIs('admin.adherents.show');
    $response->assertViewHas('adherent');
    $response->assertSee($adherent->nom_complet, false);
});

test('edit page displays adherent form', function () {
    $adherent = Adherent::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.adherents.edit', $adherent));

    $response->assertSuccessful();
    $response->assertViewIs('admin.adherents.edit');
    $response->assertViewHas('adherent');
});

test('admin can update adherent', function () {
    // Date majeure fixe : la mise à jour d'un mineur exigerait un représentant légal.
    $adherent = Adherent::factory()->create(['prenom' => 'OldPrenom', 'date_naissance' => '1990-01-01']);

    $data = [
        'civilite' => 'Mme',
        'prenom' => 'NewPrenom',
        'nom' => $adherent->nom,
        'date_naissance' => '1990-01-01',
        'statut' => 'actif',
    ];

    $response = $this->actingAs($this->admin)->put(route('admin.adherents.update', $adherent), $data);

    $response->assertRedirect();
    $this->assertDatabaseHas('adherents', [
        'id' => $adherent->id,
        'civilite' => 'Mme',
    ]);
});

test('destroy archives adherent', function () {
    $adherent = Adherent::factory()->create(['statut' => 'actif']);

    $response = $this->actingAs($this->admin)->delete(route('admin.adherents.destroy', $adherent));

    $response->assertRedirect(route('admin.adherents.index'));

    $adherent->refresh();
    expect($adherent->statut)->toBe('archive');
});

test('restore reactivates adherent', function () {
    $adherent = Adherent::factory()->create(['statut' => 'archive']);

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.restore', $adherent));

    $response->assertRedirect();

    $adherent->refresh();
    expect($adherent->statut)->toBe('actif');
});

test('store requires rgpd consent', function () {
    $data = [
        'civilite' => 'M.',
        'prenom' => 'Sans',
        'nom' => 'Consentement',
        'date_naissance' => '1990-01-01',
        'statut' => 'actif',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);

    $response->assertSessionHasErrors('consentement_rgpd');
});

test('creating a minor records representant legal and consents', function () {
    $data = [
        'civilite' => 'Autre',
        'prenom' => 'Petit',
        'nom' => 'Nageur',
        'date_naissance' => now()->subYears(12)->format('Y-m-d'),
        'statut' => 'actif',
        'consentement_rgpd' => '1',
        'autorisation_parentale' => '1',
        'representant_civilite' => 'Mme',
        'representant_prenom' => 'Marie',
        'representant_nom' => 'Nageur',
        'representant_lien_parente' => 'Mère',
        'representant_telephone' => '0612345678',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);
    $response->assertRedirect();

    $adherent = Adherent::findOrFail(adherentIdFromRedirect($response));
    expect($adherent->est_mineur)->toBeTrue();
    expect($adherent->representantsLegaux()->count())->toBe(1);
    expect($adherent->representantsLegaux()->first()->nom)->toBe('Nageur');
    expect($adherent->consentements()->where('type_consentement', 'autorisation_parentale')->exists())->toBeTrue();
    expect($adherent->consentements()->where('type_consentement', 'traitement_donnees')->exists())->toBeTrue();
});

test('minor creation fails without representant legal', function () {
    $data = [
        'civilite' => 'Autre',
        'prenom' => 'Petit',
        'nom' => 'Nageur',
        'date_naissance' => now()->subYears(10)->format('Y-m-d'),
        'statut' => 'actif',
        'consentement_rgpd' => '1',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);

    $response->assertSessionHasErrors(['representant_nom', 'representant_prenom', 'representant_lien_parente', 'autorisation_parentale']);
});

test('admin can assign roles to adherent', function () {
    $role = Role::firstOrCreate(
        ['nom' => 'entraineur'],
        ['nom_affichage' => 'Entraîneur', 'description' => 'Entraîneur du club']
    );

    $data = [
        'civilite' => 'M.',
        'prenom' => 'Coach',
        'nom' => 'Roletest',
        'date_naissance' => '1985-06-15',
        'statut' => 'actif',
        'consentement_rgpd' => '1',
        'roles' => [$role->id],
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);
    $response->assertRedirect();

    $adherent = Adherent::findOrFail(adherentIdFromRedirect($response));
    expect($adherent->roles()->where('roles.id', $role->id)->exists())->toBeTrue();
});

test('admin can upload medical certificate', function () {
    Storage::fake('local');

    $data = [
        'civilite' => 'M.',
        'prenom' => 'Certif',
        'nom' => 'Medical',
        'date_naissance' => '1985-06-15',
        'statut' => 'actif',
        'consentement_rgpd' => '1',
        'certificat_pdf' => UploadedFile::fake()->create('certificat.pdf', 200, 'application/pdf'),
        'certificat_delivre_le' => now()->subMonths(2)->format('Y-m-d'),
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);
    $response->assertRedirect();

    $adherent = Adherent::findOrFail(adherentIdFromRedirect($response));
    expect($adherent->certificatsMedicaux()->count())->toBe(1);

    $certificat = $adherent->certificatsMedicaux()->with('document')->first();
    expect($certificat->document)->not->toBeNull();
    Storage::disk('local')->assertExists($certificat->document->chemin_fichier);
});

test('non-admin cannot create adherent', function () {
    $user = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    Adherent::factory()->create(['utilisateur_id' => $user->id]);

    $data = [
        'civilite' => 'M.',
        'prenom' => 'Jean',
        'nom' => 'Dupont',
        'date_naissance' => '1990-01-01',
        'statut' => 'actif',
    ];

    $response = $this->actingAs($user)->post(route('admin.adherents.store'), $data);

    $response->assertForbidden();
});

test('non-admin cannot update adherent', function () {
    $user = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    Adherent::factory()->create(['utilisateur_id' => $user->id]);

    $adherent = Adherent::factory()->create();

    $data = [
        'civilite' => 'Mme',
        'prenom' => 'Jane',
        'nom' => 'Doe',
        'date_naissance' => '1990-01-01',
        'statut' => 'actif',
    ];

    $response = $this->actingAs($user)->put(route('admin.adherents.update', $adherent), $data);

    $response->assertForbidden();
});
