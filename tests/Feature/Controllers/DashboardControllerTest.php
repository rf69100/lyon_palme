<?php

use App\Models\Adherent;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = Utilisateur::factory()->create();
});

test('dashboard requires authentication', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('authenticated user can access dashboard', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200)
        ->assertViewIs('dashboard.adherent');
});

test('dashboard displays user stats', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200)
        ->assertViewHas('stats')
        ->assertViewHas('adhesions')
        ->assertViewHas('upcomingOutings')
        ->assertViewHas('upcomingCompetitions');
});

test('dashboard shows correct stats for adherent without data', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200);

    $stats = $response->viewData('stats');
    expect($stats['totalAdhesions'])->toBe(0)
        ->and($stats['activitesParticipees'])->toBe(0)
        ->and($stats['certificationsCount'])->toBe(0);
});

test('dashboard shows adherent status as inactif when no adherent exists', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200);

    $stats = $response->viewData('stats');
    expect($stats['statut'])->toBe('inactif');
});

test('dashboard loads adherent data when available', function () {
    $adherent = Adherent::factory()->create([
        'utilisateur_id' => $this->user->id,
        'statut' => 'actif',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200);

    $stats = $response->viewData('stats');
    expect($stats['statut'])->toBe('actif');
});

test('dashboard handles missing adherent gracefully', function () {
    // User without associated adherent
    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200)
        ->assertViewIs('dashboard.adherent');

    expect($response->viewData('adherent'))->toBeNull();
});

test('dashboard returns correct view name', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertViewIs('dashboard.adherent');
});

test('dashboard view receives all required data', function () {
    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200)
        ->assertViewHas('stats')
        ->assertViewHas('adhesions')
        ->assertViewHas('upcomingOutings')
        ->assertViewHas('upcomingCompetitions')
        ->assertViewHas('adherent');
});

test('dashboard handles errors in adhesions loading gracefully', function () {
    $adherent = Adherent::factory()->create([
        'utilisateur_id' => $this->user->id,
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('dashboard'));

    $response->assertStatus(200);

    // Should not throw exception, should return empty collection
    expect($response->viewData('adhesions'))->toBeObject();
});
