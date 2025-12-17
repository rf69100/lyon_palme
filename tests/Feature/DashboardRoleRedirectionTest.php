<?php

use App\Models\Adherent;
use App\Models\AdherentRole;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Dashboard Role Redirection', function () {

    beforeEach(function () {
        // Seed roles
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        // Create a user with an adherent
        $this->user = Utilisateur::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->adherent = Adherent::factory()->create([
            'utilisateur_id' => $this->user->id,
            'statut' => 'actif',
        ]);
    });

    test('adherent without administrative role sees adherent dashboard', function () {
        // Act as the user
        $response = $this->actingAs($this->user)->get('/dashboard');

        // Should see adherent dashboard view
        $response->assertSuccessful();
        $response->assertViewIs('dashboard.adherent');
        $response->assertViewHas('adherent', $this->adherent);
    });

    test('adherent with secretary role sees secretary dashboard', function () {
        // Get secretary role
        $secretaryRole = Role::where('nom', Role::SECRETAIRE)->first();

        // Assign secretary role to adherent
        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $secretaryRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        // Act as the user
        $response = $this->actingAs($this->user)->get('/dashboard');

        // Should see secretary dashboard view
        $response->assertSuccessful();
        $response->assertViewIs('dashboard.secretary');
        $response->assertViewHas('adherent', $this->adherent);
    });

    test('adherent with president role sees secretary dashboard', function () {
        // Get president role
        $presidentRole = Role::where('nom', Role::PRESIDENT)->first();

        // Assign president role to adherent
        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $presidentRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        // Act as the user
        $response = $this->actingAs($this->user)->get('/dashboard');

        // Should see secretary dashboard view (administrative dashboard)
        $response->assertSuccessful();
        $response->assertViewIs('dashboard.secretary');
        $response->assertViewHas('adherent', $this->adherent);
    });

    test('adherent with treasurer role sees secretary dashboard', function () {
        // Get treasurer role
        $treasurerRole = Role::where('nom', Role::TRESORIER)->first();

        // Assign treasurer role to adherent
        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $treasurerRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        // Act as the user
        $response = $this->actingAs($this->user)->get('/dashboard');

        // Should see secretary dashboard view (administrative dashboard)
        $response->assertSuccessful();
        $response->assertViewIs('dashboard.secretary');
        $response->assertViewHas('adherent', $this->adherent);
    });

    test('adherent with inactive role sees adherent dashboard', function () {
        // Get secretary role
        $secretaryRole = Role::where('nom', Role::SECRETAIRE)->first();

        // Assign inactive secretary role to adherent
        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $secretaryRole->id,
            'attribue_le' => now(),
            'est_actif' => false,
            'revoque_le' => now(),
        ]);

        // Act as the user
        $response = $this->actingAs($this->user)->get('/dashboard');

        // Should see adherent dashboard view (role is inactive)
        $response->assertSuccessful();
        $response->assertViewIs('dashboard.adherent');
        $response->assertViewHas('adherent', $this->adherent);
    });

    test('adherent with revoked role sees adherent dashboard', function () {
        // Get secretary role
        $secretaryRole = Role::where('nom', Role::SECRETAIRE)->first();

        // Assign revoked secretary role to adherent
        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $secretaryRole->id,
            'attribue_le' => now()->subDays(30),
            'revoque_le' => now()->subDays(5),
            'est_actif' => false,
        ]);

        // Act as the user
        $response = $this->actingAs($this->user)->get('/dashboard');

        // Should see adherent dashboard view (role is revoked)
        $response->assertSuccessful();
        $response->assertViewIs('dashboard.adherent');
        $response->assertViewHas('adherent', $this->adherent);
    });

    test('user without adherent profile sees adherent dashboard', function () {
        // Create a user without an adherent profile
        $userWithoutAdherent = Utilisateur::factory()->create([
            'email' => 'noadherent@example.com',
        ]);

        // Act as the user
        $response = $this->actingAs($userWithoutAdherent)->get('/dashboard');

        // Should see adherent dashboard with null adherent
        $response->assertSuccessful();
        $response->assertViewIs('dashboard.adherent');
        $response->assertViewHas('adherent', null);
    });
});

describe('Adherent Role Helper Methods', function () {

    beforeEach(function () {
        // Seed roles
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        $this->adherent = Adherent::factory()->create([
            'statut' => 'actif',
        ]);
    });

    test('hasRole returns true when adherent has active role', function () {
        $secretaryRole = Role::where('nom', Role::SECRETAIRE)->first();

        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $secretaryRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        expect($this->adherent->hasRole(Role::SECRETAIRE))->toBeTrue();
        expect($this->adherent->hasRole(Role::PRESIDENT))->toBeFalse();
    });

    test('hasAnyRole returns true when adherent has any of the specified roles', function () {
        $secretaryRole = Role::where('nom', Role::SECRETAIRE)->first();

        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $secretaryRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        expect($this->adherent->hasAnyRole([Role::SECRETAIRE, Role::PRESIDENT]))->toBeTrue();
        expect($this->adherent->hasAnyRole([Role::PRESIDENT, Role::TRESORIER]))->toBeFalse();
    });

    test('estAdministrateur returns true for administrative roles', function () {
        $secretaryRole = Role::where('nom', Role::SECRETAIRE)->first();

        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $secretaryRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        expect($this->adherent->estAdministrateur())->toBeTrue();
    });

    test('estAdministrateur returns false for non-administrative roles', function () {
        $adherentRole = Role::where('nom', Role::ADHERENT)->first();

        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $adherentRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        expect($this->adherent->estAdministrateur())->toBeFalse();
    });

    test('rolesActifs returns only active non-revoked roles', function () {
        $secretaryRole = Role::where('nom', Role::SECRETAIRE)->first();
        $presidentRole = Role::where('nom', Role::PRESIDENT)->first();

        // Active role
        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $secretaryRole->id,
            'attribue_le' => now(),
            'est_actif' => true,
        ]);

        // Revoked role
        AdherentRole::create([
            'adherent_id' => $this->adherent->id,
            'role_id' => $presidentRole->id,
            'attribue_le' => now()->subDays(30),
            'revoque_le' => now()->subDays(5),
            'est_actif' => false,
        ]);

        $activeRoles = $this->adherent->rolesActifs()->get();

        expect($activeRoles)->toHaveCount(1);
        expect($activeRoles->first()->nom)->toBe(Role::SECRETAIRE);
    });
});
