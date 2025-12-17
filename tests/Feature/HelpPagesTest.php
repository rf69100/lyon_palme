<?php

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guide de gestion page requires authentication', function () {
    $response = $this->get(route('help.guide'));

    $response->assertRedirect(route('login'));
});

test('faq page requires authentication', function () {
    $response = $this->get(route('help.faq'));

    $response->assertRedirect(route('login'));
});

test('contact admin page requires authentication', function () {
    $response = $this->get(route('help.contact'));

    $response->assertRedirect(route('login'));
});

test('authenticated user can access guide de gestion page', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('help.guide'));

    $response->assertSuccessful();
    $response->assertViewIs('help.guide-gestion');
    $response->assertSee('Guide de gestion', false);
});

test('authenticated user can access faq page', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('help.faq'));

    $response->assertSuccessful();
    $response->assertViewIs('help.faq');
    $response->assertSee('FAQ Secrétaire');
});

test('authenticated user can access contact admin page', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('help.contact'));

    $response->assertSuccessful();
    $response->assertViewIs('help.contact-admin');
    $response->assertSee('Contacter l', false);
});

test('help pages have back to dashboard links', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $guideResponse = $this->actingAs($user)->get(route('help.guide'));
    $faqResponse = $this->actingAs($user)->get(route('help.faq'));
    $contactResponse = $this->actingAs($user)->get(route('help.contact'));

    $guideResponse->assertSee('Retour au dashboard');
    $faqResponse->assertSee('Retour au dashboard');
    $contactResponse->assertSee('Retour au dashboard');
});
