<?php

/**
 * EXEMPLE D'UTILISATION DU HASHAGE AUTOMATIQUE DES MOTS DE PASSE
 *
 * Ce fichier démontre comment le modèle Utilisateur hashe automatiquement
 * les mots de passe grâce au cast 'hashed' de Laravel 12.
 *
 * Pour exécuter : php artisan tinker, puis copier-coller les exemples
 */

use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

// ============================================================================
// EXEMPLE 1 : Création d'un utilisateur avec hashage automatique
// ============================================================================

$utilisateur = new Utilisateur();
$utilisateur->nom = 'Jean Dupont';
$utilisateur->email = 'jean.dupont@lyonpalme.fr';
$utilisateur->mot_de_passe = 'MonMotDePasseSecret123'; // <- Texte en clair

// Le mot de passe est automatiquement hashé lors de l'assignation
// Vous n'avez PAS besoin de faire Hash::make() manuellement !

echo "Mot de passe original : MonMotDePasseSecret123\n";
echo "Mot de passe hashé : " . $utilisateur->mot_de_passe . "\n";
// Sortie : $2y$12$... (hash bcrypt)


// ============================================================================
// EXEMPLE 2 : Vérification du mot de passe
// ============================================================================

// Pour vérifier un mot de passe lors de la connexion :
if (Hash::check('MonMotDePasseSecret123', $utilisateur->mot_de_passe)) {
    echo "✓ Mot de passe correct !\n";
} else {
    echo "✗ Mot de passe incorrect.\n";
}


// ============================================================================
// EXEMPLE 3 : Création via mass assignment
// ============================================================================

$nouvelUtilisateur = Utilisateur::create([
    'nom' => 'Marie Martin',
    'email' => 'marie.martin@lyonpalme.fr',
    'mot_de_passe' => 'AutreMotDePasse456', // Automatiquement hashé !
]);

// Le mot de passe est déjà hashé dans la base de données


// ============================================================================
// EXEMPLE 4 : Modification du mot de passe
// ============================================================================

$utilisateur = Utilisateur::find(1);
$utilisateur->mot_de_passe = 'NouveauMotDePasse789'; // Automatiquement hashé
$utilisateur->save();

// Lors de la connexion, Laravel vérifiera automatiquement :
// Auth::attempt(['email' => $email, 'mot_de_passe' => $password])


// ============================================================================
// EXEMPLE 5 : Éviter le double hashage
// ============================================================================

// IMPORTANT : Si vous réassignez un hash existant, il ne sera PAS re-hashé
$hash = $utilisateur->mot_de_passe; // Récupère le hash
$utilisateur->mot_de_passe = $hash;  // Réassigne le même hash
// Le système détecte que c'est déjà un hash et ne le re-hashe pas


// ============================================================================
// CONFIGURATION DU NOMBRE DE ROUNDS BCRYPT
// ============================================================================

// Le nombre de rounds est configuré dans .env :
// BCRYPT_ROUNDS=12
//
// Plus le nombre est élevé, plus le hashage est sécurisé mais lent
// Valeur recommandée : 10-12 pour la production


// ============================================================================
// EXEMPLE D'UTILISATION AVEC L'AUTHENTIFICATION LARAVEL
// ============================================================================

/*
// Dans un controller :

use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;

// Enregistrement d'un nouvel utilisateur
$utilisateur = Utilisateur::create([
    'nom' => $request->nom,
    'email' => $request->email,
    'mot_de_passe' => $request->mot_de_passe, // Hashé automatiquement
]);

// Connexion (Laravel vérifie automatiquement le hash)
if (Auth::attempt(['email' => $request->email, 'mot_de_passe' => $request->mot_de_passe])) {
    // Authentification réussie
    return redirect()->intended('dashboard');
}

// Changement de mot de passe
$utilisateur = Auth::user();
$utilisateur->mot_de_passe = $request->nouveau_mot_de_passe; // Hashé automatiquement
$utilisateur->doit_changer_mdp = false;
$utilisateur->save();
*/


// ============================================================================
// AVANTAGES DU CAST 'hashed' (Laravel 12+)
// ============================================================================

/*
✓ Hashage automatique : Plus besoin de Hash::make() manuellement
✓ Évite le double hashage : Détecte automatiquement si déjà hashé
✓ Code plus propre : Moins de code boilerplate
✓ Sécurité : Impossible d'oublier de hasher un mot de passe
✓ Cohérence : Tous les mots de passe sont hashés de la même manière
*/


// ============================================================================
// MIGRATION DEPUIS L'ANCIEN SYSTÈME
// ============================================================================

/*
Si vous aviez du code comme :

    // Ancien code (Laravel < 12)
    $utilisateur->mot_de_passe = Hash::make($request->mot_de_passe);

Vous pouvez maintenant simplement écrire :

    // Nouveau code (Laravel 12+)
    $utilisateur->mot_de_passe = $request->mot_de_passe;

Le hash est appliqué automatiquement !
*/
