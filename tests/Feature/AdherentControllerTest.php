<?php

use App\Models\Adherent;
use App\Models\AdherentRole;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.adherents.store'), $data);

    $response->assertRedirect();
    $this->assertDatabaseHas('adherents', [
        'prenom' => 'Jean',
        'nom' => 'Dupont',
        'statut' => 'actif',
    ]);
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
    $adherent = Adherent::factory()->create(['prenom' => 'OldPrenom']);

    $data = [
        'civilite' => 'Mme',
        'prenom' => 'NewPrenom',
        'nom' => $adherent->nom,
        'date_naissance' => $adherent->date_naissance,
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
