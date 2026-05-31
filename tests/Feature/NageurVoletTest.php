<?php

use App\Models\Adherent;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Crée un nageur (utilisateur vérifié + fiche adhérent liée, sans rôle admin). */
function makeNageur(array $adherentAttrs = []): array
{
    $utilisateur = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    $adherent = Adherent::factory()->create(array_merge([
        'utilisateur_id' => $utilisateur->id,
        'statut' => 'actif',
    ], $adherentAttrs));

    return [$utilisateur, $adherent];
}

test('mon profil requires authentication', function () {
    $this->get(route('mon-profil.edit'))->assertRedirect(route('login'));
});

test('nageur can view own profil', function () {
    [$user] = makeNageur();

    $this->actingAs($user)->get(route('mon-profil.edit'))
        ->assertSuccessful()
        ->assertViewIs('mon-profil.edit');
});

test('nageur can update coordonnees and visibility', function () {
    [$user, $adherent] = makeNageur([
        'afficher_trombinoscope' => false,
        'afficher_annuaire' => false,
    ]);

    $response = $this->actingAs($user)->put(route('mon-profil.update'), [
        'email' => 'nageur.maj@example.com',
        'telephone' => '0455667788',
        'afficher_trombinoscope' => '1',
        'afficher_annuaire' => '1',
    ]);

    $response->assertRedirect(route('mon-profil.edit'));

    $adherent->refresh();
    expect($adherent->afficher_trombinoscope)->toBeTrue();
    expect($adherent->afficher_annuaire)->toBeTrue();
    expect($adherent->email)->toBe('nageur.maj@example.com');
    expect($adherent->telephone)->toBe('0455667788');
});

test('unchecked visibility boxes turn preferences off', function () {
    [$user, $adherent] = makeNageur([
        'afficher_trombinoscope' => true,
        'afficher_annuaire' => true,
    ]);

    $this->actingAs($user)->put(route('mon-profil.update'), [
        // aucune case cochée
    ])->assertRedirect();

    $adherent->refresh();
    expect($adherent->afficher_trombinoscope)->toBeFalse();
    expect($adherent->afficher_annuaire)->toBeFalse();
});

test('trombinoscope shows opted-in and hides opted-out swimmers', function () {
    [$user] = makeNageur();
    makeNageur(['nom' => 'Trombiouiunique', 'afficher_trombinoscope' => true]);
    makeNageur(['nom' => 'Trombinonunique', 'afficher_trombinoscope' => false]);

    $this->actingAs($user)->get(route('trombinoscope'))
        ->assertSuccessful()
        ->assertSee('Trombiouiunique')
        ->assertDontSee('Trombinonunique');
});

test('annuaire shows opted-in and hides opted-out swimmers', function () {
    [$user] = makeNageur();
    makeNageur(['nom' => 'Annuouiunique', 'afficher_annuaire' => true]);
    makeNageur(['nom' => 'Annunonunique', 'afficher_annuaire' => false]);

    $this->actingAs($user)->get(route('annuaire'))
        ->assertSuccessful()
        ->assertSee('Annuouiunique')
        ->assertDontSee('Annunonunique');
});

test('archived swimmers never appear in trombinoscope', function () {
    [$user] = makeNageur();
    makeNageur(['nom' => 'Archivetrombi', 'afficher_trombinoscope' => true, 'statut' => 'archive']);

    $this->actingAs($user)->get(route('trombinoscope'))
        ->assertSuccessful()
        ->assertDontSee('Archivetrombi');
});

test('secretary can create a login account for an adherent', function () {
    $admin = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    $this->grantAdminRole($admin);

    $email = 'compte.'.uniqid().'@example.com';
    $adherent = Adherent::factory()->create([
        'utilisateur_id' => null,
        'email' => $email,
        'date_naissance' => '2000-03-15',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.adherents.create-account', $adherent))
        ->assertRedirect();

    $adherent->refresh();
    expect($adherent->utilisateur_id)->not->toBeNull();

    $utilisateur = Utilisateur::find($adherent->utilisateur_id);
    expect($utilisateur->email)->toBe($email);
    // Mot de passe initial = date de naissance AAAAMMJJ
    expect(Hash::check('20000315', $utilisateur->mot_de_passe))->toBeTrue();
});

test('creating an account twice is rejected', function () {
    $admin = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    $this->grantAdminRole($admin);

    [, $adherent] = makeNageur(['email' => 'deja.'.uniqid().'@example.com']);

    $this->actingAs($admin)
        ->post(route('admin.adherents.create-account', $adherent))
        ->assertSessionHas('error');
});
