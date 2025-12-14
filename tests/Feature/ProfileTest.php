<?php

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

uses(RefreshDatabase::class);
uses(WithoutMiddleware::class);

it('permet de mettre à jour le nom', function () {
    $user = Utilisateur::factory()->create([
        'nom' => 'Ancien Nom',
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nom' => 'Nouveau Nom',
        'email' => $user->email,
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHas('success');

    expect($user->fresh()->nom)->toBe('Nouveau Nom');
});

it('permet de mettre à jour l\'email', function () {
    $user = Utilisateur::factory()->create([
        'email' => 'ancien@example.com',
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nom' => $user->nom,
        'email' => 'nouveau@example.com',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHas('success');

    expect($user->fresh()->email)->toBe('nouveau@example.com');
});

it('valide que le nom est requis', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nom' => '',
        'email' => $user->email,
    ]);

    $response->assertSessionHasErrors('nom');
});

it('valide que l\'email est requis', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nom' => $user->nom,
        'email' => '',
    ]);

    $response->assertSessionHasErrors('email');
});

it('valide que l\'email doit être valide', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nom' => $user->nom,
        'email' => 'email-invalide',
    ]);

    $response->assertSessionHasErrors('email');
});

it('valide que l\'email doit être unique', function () {
    $user = Utilisateur::factory()->create([
        'email_verifie_le' => now(),
    ]);

    $otherUser = Utilisateur::factory()->create([
        'email' => 'autre@example.com',
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nom' => $user->nom,
        'email' => 'autre@example.com',
    ]);

    $response->assertSessionHasErrors('email');
});

it('permet de garder le même email lors de la mise à jour', function () {
    $user = Utilisateur::factory()->create([
        'email' => 'meme@example.com',
        'email_verifie_le' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nom' => 'Nom Modifié',
        'email' => 'meme@example.com',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHasNoErrors();

    expect($user->fresh()->email)->toBe('meme@example.com');
    expect($user->fresh()->nom)->toBe('Nom Modifié');
});
