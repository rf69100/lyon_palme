<?php

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

uses(RefreshDatabase::class);
uses(WithoutMiddleware::class);

it('permet d\'envoyer un message de support', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('support.store'), [
        'subject' => 'Problème de connexion',
        'message' => 'Je ne peux pas me connecter à mon compte.',
    ]);

    $response->assertRedirect(route('support.index'));
    $response->assertSessionHas('success');
});

it('valide que le sujet est requis', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('support.store'), [
        'subject' => '',
        'message' => 'Mon message de support',
    ]);

    $response->assertSessionHasErrors('subject');
});

it('valide que le message est requis', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('support.store'), [
        'subject' => 'Mon sujet',
        'message' => '',
    ]);

    $response->assertSessionHasErrors('message');
});

it('valide que le sujet ne doit pas dépasser 255 caractères', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('support.store'), [
        'subject' => str_repeat('a', 256),
        'message' => 'Mon message de support',
    ]);

    $response->assertSessionHasErrors('subject');
});

it('valide que le message doit contenir au moins 10 caractères', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('support.store'), [
        'subject' => 'Mon sujet',
        'message' => 'Court',
    ]);

    $response->assertSessionHasErrors('message');
});

it('accepte un message de support valide', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('support.store'), [
        'subject' => 'Demande d\'aide',
        'message' => 'Ceci est un message de support valide avec plus de 10 caractères.',
    ]);

    $response->assertRedirect(route('support.index'));
    $response->assertSessionHasNoErrors();
});
