<?php

use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

test('le mot de passe est automatiquement hashé lors de la création', function () {
    $plainPassword = 'MotDePasseSecret123';

    $utilisateur = new Utilisateur();
    $utilisateur->nom = 'Test User';
    $utilisateur->email = 'test@example.com';
    $utilisateur->mot_de_passe = $plainPassword;

    // Le mot de passe ne doit pas être stocké en clair
    expect($utilisateur->mot_de_passe)->not->toBe($plainPassword);

    // Le mot de passe doit être un hash valide
    expect(Hash::check($plainPassword, $utilisateur->mot_de_passe))->toBeTrue();
});

test('le mot de passe est automatiquement hashé lors de la modification', function () {
    $utilisateur = new Utilisateur();
    $utilisateur->nom = 'Test User';
    $utilisateur->email = 'test2@example.com';
    $utilisateur->mot_de_passe = 'AncienMotDePasse';

    $nouveauPassword = 'NouveauMotDePasse123';
    $utilisateur->mot_de_passe = $nouveauPassword;

    // Le nouveau mot de passe ne doit pas être stocké en clair
    expect($utilisateur->mot_de_passe)->not->toBe($nouveauPassword);

    // Le nouveau mot de passe doit être un hash valide
    expect(Hash::check($nouveauPassword, $utilisateur->mot_de_passe))->toBeTrue();
});

test('le mot de passe hashé ne change pas si on réassigne le même hash', function () {
    $utilisateur = new Utilisateur();
    $utilisateur->nom = 'Test User';
    $utilisateur->email = 'test3@example.com';
    $utilisateur->mot_de_passe = 'MotDePasse123';

    $hash = $utilisateur->mot_de_passe;

    // Réassigner le même hash ne doit pas créer un nouveau hash
    $utilisateur->mot_de_passe = $hash;

    expect($utilisateur->mot_de_passe)->toBe($hash);
});
