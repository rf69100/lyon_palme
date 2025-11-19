<?php

/**
 * EXEMPLE D'UTILISATION DU CHIFFREMENT DES DONNÉES PERSONNELLES
 *
 * Ce fichier démontre comment utiliser le système de chiffrement automatique
 * des données sensibles dans le projet Lyon Palme.
 *
 * Pour exécuter : php artisan tinker, puis copier-coller les exemples
 */

use App\Models\Adherent;
use App\Models\RepresentantLegal;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

// ============================================================================
// EXEMPLE 1 : Création d'un adhérent avec chiffrement automatique
// ============================================================================

$adherent = Adherent::create([
    'civilite' => 'M.',
    'prenom' => 'Jean',
    'nom' => 'Dupont',
    'date_naissance' => '1990-05-15',
    'email' => 'jean.dupont@lyonpalme.fr',
    'telephone' => '04 72 12 34 56',      // <- Chiffré automatiquement
    'mobile' => '06 12 34 56 78',         // <- Chiffré automatiquement
    'numero_rue' => '123',                // <- Chiffré automatiquement
    'rue' => 'Rue de la République',      // <- Chiffré automatiquement
    'complement_adresse' => 'Bât. A',     // <- Chiffré automatiquement
    'code_postal' => '69001',             // <- Chiffré automatiquement
    'ville' => 'Lyon',                    // <- Chiffré automatiquement
    'pays' => 'France',
    'contact_urgence_nom' => 'Marie Dupont',           // <- Chiffré
    'contact_urgence_telephone' => '06 98 76 54 32',   // <- Chiffré
    'contact_urgence_lien' => 'Épouse',                // <- Chiffré
    'statut' => 'actif',
    'est_mineur' => false,
]);

echo "Adhérent créé avec ID : " . $adherent->id . "\n";


// ============================================================================
// EXEMPLE 2 : Lecture des données (déchiffrement automatique)
// ============================================================================

$adherent = Adherent::find(1);

// Les données sont automatiquement déchiffrées !
echo "Téléphone : " . $adherent->telephone . "\n";  // Affiche : 04 72 12 34 56
echo "Mobile : " . $adherent->mobile . "\n";        // Affiche : 06 12 34 56 78
echo "Adresse : " . $adherent->rue . "\n";          // Affiche : Rue de la République
echo "Code postal : " . $adherent->code_postal . "\n";  // Affiche : 69001
echo "Ville : " . $adherent->ville . "\n";          // Affiche : Lyon

// Utiliser l'attribut calculé pour l'adresse complète
echo "Adresse complète : " . $adherent->adresse_complete . "\n";
// Affiche : 123, Rue de la République, Bât. A, 69001 Lyon


// ============================================================================
// EXEMPLE 3 : Vérifier que les données sont chiffrées en base
// ============================================================================

// Récupérer les données BRUTES (chiffrées) depuis la base
$rawData = DB::table('adherents')->where('id', $adherent->id)->first();

echo "Téléphone en base (chiffré) : " . substr($rawData->telephone, 0, 50) . "...\n";
// Affiche : eyJpdiI6IjRkZjN3Y2JhN2U5ZTQ1ZGE4ZjA3YTVjZDY...

echo "Mobile en base (chiffré) : " . substr($rawData->mobile, 0, 50) . "...\n";
// Affiche : eyJpdiI6IjlhYmMyZGVmMzQ1Njc4OWFiY2RlZjEy...

// Les données en base sont bien chiffrées !


// ============================================================================
// EXEMPLE 4 : Modification des données (re-chiffrement automatique)
// ============================================================================

$adherent = Adherent::find(1);

// Modifier les données sensibles
$adherent->telephone = '04 78 98 76 54';
$adherent->mobile = '06 87 65 43 21';
$adherent->rue = 'Avenue Jean Jaurès';
$adherent->ville = 'Villeurbanne';

// Sauvegarder - les nouvelles valeurs sont automatiquement chiffrées
$adherent->save();

echo "Données mises à jour et re-chiffrées !\n";


// ============================================================================
// EXEMPLE 5 : Création d'un représentant légal (mineur)
// ============================================================================

// D'abord, créer un adhérent mineur
$mineur = Adherent::create([
    'civilite' => 'M.',
    'prenom' => 'Lucas',
    'nom' => 'Martin',
    'date_naissance' => '2010-03-20',
    'email' => 'parent.martin@lyonpalme.fr',
    'statut' => 'actif',
    'est_mineur' => true,
]);

// Créer le représentant légal avec chiffrement automatique
$representant = RepresentantLegal::create([
    'adherent_mineur_id' => $mineur->id,
    'civilite' => 'Mme',
    'prenom' => 'Sophie',
    'nom' => 'Martin',
    'lien_parente' => 'Mère',
    'email' => 'sophie.martin@example.com',
    'telephone' => '04 72 11 22 33',      // <- Chiffré automatiquement
    'mobile' => '06 11 22 33 44',         // <- Chiffré automatiquement
    'numero_rue' => '45',                 // <- Chiffré automatiquement
    'rue' => 'Boulevard des Belges',      // <- Chiffré automatiquement
    'code_postal' => '69006',             // <- Chiffré automatiquement
    'ville' => 'Lyon',                    // <- Chiffré automatiquement
    'pays' => 'France',
    'est_principal' => true,
    'peut_recuperer' => true,
    'autorise_sortie' => true,
    'autorise_transport' => true,
]);

echo "Représentant légal créé pour " . $mineur->nom_complet . "\n";


// ============================================================================
// EXEMPLE 6 : Relations et chiffrement
// ============================================================================

$mineur = Adherent::with('representantsLegaux')->find($mineur->id);

foreach ($mineur->representantsLegaux as $rep) {
    // Les données du représentant sont automatiquement déchiffrées
    echo "Représentant : " . $rep->nom_complet . "\n";
    echo "  Téléphone : " . $rep->telephone . "\n";
    echo "  Adresse : " . $rep->adresse_complete . "\n";
    echo "  Principal : " . ($rep->estPrincipal() ? 'Oui' : 'Non') . "\n";
}


// ============================================================================
// EXEMPLE 7 : Export JSON (déchiffrement automatique)
// ============================================================================

$adherent = Adherent::find(1);

// Convertir en JSON - les données chiffrées sont déchiffrées
$json = $adherent->toJson();
$array = $adherent->toArray();

echo "Export JSON :\n";
echo json_encode([
    'nom' => $array['nom'],
    'telephone' => $array['telephone'],  // Déchiffré dans le JSON
    'ville' => $array['ville'],          // Déchiffré dans le JSON
], JSON_PRETTY_PRINT) . "\n";


// ============================================================================
// EXEMPLE 8 : Gestion des valeurs nulles
// ============================================================================

$adherent = Adherent::create([
    'civilite' => 'Mme',
    'prenom' => 'Marie',
    'nom' => 'Durand',
    'date_naissance' => '1985-08-10',
    'telephone' => null,      // NULL n'est pas chiffré
    'mobile' => null,         // NULL n'est pas chiffré
    'statut' => 'actif',
]);

echo "Téléphone (null) : " . ($adherent->telephone ?? 'NULL') . "\n";
echo "Mobile (null) : " . ($adherent->mobile ?? 'NULL') . "\n";


// ============================================================================
// EXEMPLE 9 : Recherche (limitations)
// ============================================================================

// ❌ ATTENTION : La recherche sur champs chiffrés n'est PAS performante
// Car chaque ligne doit être déchiffrée pour comparer

// Utiliser des champs NON chiffrés pour la recherche
$adherents = Adherent::where('nom', 'LIKE', 'Dupont%')->get();
$adherents = Adherent::where('email', 'jean.dupont@lyonpalme.fr')->get();

// ✅ Recherche efficace sur champs non chiffrés (nom, prenom, email)


// ============================================================================
// EXEMPLE 10 : Scopes et méthodes helpers
// ============================================================================

// Récupérer tous les adhérents actifs
$actifs = Adherent::actif()->get();

// Récupérer tous les mineurs
$mineurs = Adherent::mineur()->get();

foreach ($mineurs as $mineur) {
    echo $mineur->nom_complet . " - ";
    echo "Mineur : " . ($mineur->estMineur() ? 'Oui' : 'Non') . "\n";

    // Récupérer les représentants
    foreach ($mineur->representantsLegaux as $rep) {
        echo "  Représentant : " . $rep->nom_complet . "\n";
        echo "  Téléphone : " . $rep->telephone . "\n";  // Déchiffré
    }
}


// ============================================================================
// EXEMPLE 11 : Vérifier manuellement le chiffrement
// ============================================================================

$adherent = Adherent::create([
    'civilite' => 'M.',
    'prenom' => 'Test',
    'nom' => 'Encryption',
    'date_naissance' => '1990-01-01',
    'telephone' => '0123456789',
    'statut' => 'actif',
]);

// Méthode 1 : Via getAttributes() (attributs bruts/chiffrés)
$raw = $adherent->getAttributes();
echo "Téléphone brut (chiffré) : " . substr($raw['telephone'], 0, 50) . "...\n";

// Méthode 2 : Via requête SQL directe
$rawDb = DB::table('adherents')->where('id', $adherent->id)->first();
echo "Téléphone en DB (chiffré) : " . substr($rawDb->telephone, 0, 50) . "...\n";

// Déchiffrer manuellement (si besoin)
$decrypted = Crypt::decryptString($raw['telephone']);
echo "Téléphone déchiffré manuellement : " . $decrypted . "\n";


// ============================================================================
// EXEMPLE 12 : Compatibilité avec anciennes données non chiffrées
// ============================================================================

// Simuler une ancienne donnée non chiffrée
$adherent = new Adherent();
$adherent->setRawAttributes([
    'id' => 999,
    'prenom' => 'Ancien',
    'nom' => 'Utilisateur',
    'date_naissance' => '1980-01-01',
    'telephone' => '0111111111',  // Ancienne valeur NON chiffrée
    'mobile' => Crypt::encryptString('0622222222'),  // Nouvelle valeur chiffrée
    'statut' => 'actif',
], true);

// Les deux formats fonctionnent !
echo "Téléphone (ancien format non chiffré) : " . $adherent->telephone . "\n";  // 0111111111
echo "Mobile (nouveau format chiffré) : " . $adherent->mobile . "\n";           // 0622222222


// ============================================================================
// EXEMPLE 13 : Batch operations (performance)
// ============================================================================

// Créer plusieurs adhérents en batch
$adherents = [];
for ($i = 1; $i <= 10; $i++) {
    $adherents[] = [
        'civilite' => 'M.',
        'prenom' => 'Adherent',
        'nom' => "Test $i",
        'date_naissance' => '1990-01-01',
        'telephone' => "012345678$i",
        'mobile' => "061234567$i",
        'rue' => "Rue Test $i",
        'code_postal' => '69001',
        'ville' => 'Lyon',
        'statut' => 'actif',
        'cree_le' => now(),
        'modifie_le' => now(),
    ];
}

// Note : Les inserts batch nécessitent un pré-chiffrement manuel
// car les events Eloquent ne sont pas déclenchés

foreach ($adherents as &$data) {
    if (isset($data['telephone'])) {
        $data['telephone'] = Crypt::encryptString($data['telephone']);
    }
    if (isset($data['mobile'])) {
        $data['mobile'] = Crypt::encryptString($data['mobile']);
    }
    if (isset($data['rue'])) {
        $data['rue'] = Crypt::encryptString($data['rue']);
    }
    // ... autres champs
}

DB::table('adherents')->insert($adherents);
echo "10 adhérents créés en batch avec chiffrement manuel\n";


// ============================================================================
// EXEMPLE 14 : Archiver un adhérent
// ============================================================================

$adherent = Adherent::find(1);

// Les données chiffrées restent chiffrées même après archivage
$adherent->archiver();

echo "Adhérent archivé : " . $adherent->statut . "\n";
echo "Date d'archivage : " . $adherent->archive_le->format('d/m/Y') . "\n";

// Les données restent accessibles (déchiffrées)
echo "Téléphone (toujours accessible) : " . $adherent->telephone . "\n";

// Réactiver
$adherent->reactiver();
echo "Adhérent réactivé : " . $adherent->statut . "\n";


// ============================================================================
// BONNES PRATIQUES
// ============================================================================

/*
✅ À FAIRE :
- Utiliser Adherent::create() pour insertion simple
- Laisser le trait gérer le chiffrement/déchiffrement
- Rechercher sur des champs NON chiffrés (nom, prenom, email)
- Utiliser les relations Eloquent normalement
- Exporter en JSON/Array normalement

❌ À ÉVITER :
- Recherche LIKE sur champs chiffrés (très lent)
- Trier (ORDER BY) sur champs chiffrés (ne fonctionne pas)
- Créer des index sur champs chiffrés (inutile)
- Déchiffrer manuellement (sauf cas particulier)
- Insérer en batch sans pré-chiffrer manuellement

⚠️ ATTENTION :
- Ne JAMAIS changer APP_KEY en production (données indéchiffrables)
- Ne JAMAIS commiter APP_KEY dans Git
- Sauvegarder APP_KEY de manière sécurisée
- Logger uniquement les données non sensibles
*/
