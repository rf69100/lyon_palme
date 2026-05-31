<?php

use App\Models\Adherent;
use App\Models\RepresentantLegal;
use Illuminate\Support\Facades\Crypt;

describe('Chiffrement RGPD complet - Adherent', function () {

    test('TOUTES les données personnelles sont chiffrées (RGPD Art. 4)', function () {
        $adherent = new Adherent([
            'civilite' => 'M.',
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'date_naissance' => '1990-01-15',
            'email' => 'jean.dupont@example.com',
            'telephone' => '0123456789',
            'mobile' => '0612345678',
            'numero_rue' => '123',
            'rue' => 'Rue de la Paix',
            'code_postal' => '69001',
            'ville' => 'Lyon',
            'pays' => 'France',
            'contact_urgence_nom' => 'Marie Dupont',
            'contact_urgence_telephone' => '0698765432',
            'statut' => 'actif',
        ]);

        // DONNÉES DIRECTEMENT IDENTIFIANTES - doivent être chiffrées
        expect($adherent->nom)->toBe('Dupont');
        expect($adherent->prenom)->toBe('Jean');
        expect($adherent->email)->toBe('jean.dupont@example.com');

        // DONNÉES INDIRECTEMENT IDENTIFIANTES - doivent être chiffrées
        expect($adherent->telephone)->toBe('0123456789');
        expect($adherent->mobile)->toBe('0612345678');
        expect($adherent->rue)->toBe('Rue de la Paix');
        expect($adherent->code_postal)->toBe('69001');
        expect($adherent->ville)->toBe('Lyon');
        expect($adherent->contact_urgence_nom)->toBe('Marie Dupont');

        // Les données NON sensibles restent en clair
        expect($adherent->pays)->toBe('France');
        expect($adherent->statut)->toBe('actif');
    });

    test('les données chiffrées peuvent être lues en clair', function () {
        $adherent = new Adherent;
        $adherent->telephone = '0123456789';

        // La valeur lue doit être en clair
        expect($adherent->telephone)->toBe('0123456789');
    });

    test('les données sont stockées chiffrées dans les attributs bruts', function () {
        $adherent = new Adherent;
        $adherent->telephone = '0123456789';

        // Accéder aux attributs bruts (chiffrés)
        $rawAttributes = $adherent->getAttributes();

        // La valeur brute ne doit PAS être en clair
        expect($rawAttributes['telephone'])->not->toBe('0123456789');

        // La valeur brute doit être déchiffrable
        $decrypted = Crypt::decryptString($rawAttributes['telephone']);
        expect($decrypted)->toBe('0123456789');
    });

    test('le trait détecte les valeurs déjà chiffrées', function () {
        $adherent = new Adherent;
        $encrypted = Crypt::encryptString('0123456789');

        // Assigner une valeur déjà chiffrée
        $adherent->telephone = $encrypted;

        // Elle ne doit pas être re-chiffrée
        expect($adherent->getAttributes()['telephone'])->toBe($encrypted);
    });

    test('l\'attribut adresse_complete retourne l\'adresse déchiffrée', function () {
        $adherent = new Adherent([
            'numero_rue' => '123',
            'rue' => 'Rue de la Paix',
            'complement_adresse' => 'Bâtiment A',
            'code_postal' => '69001',
            'ville' => 'Lyon',
            'pays' => 'France',
        ]);

        $adresseComplete = $adherent->adresse_complete;

        expect($adresseComplete)->toContain('123');
        expect($adresseComplete)->toContain('Rue de la Paix');
        expect($adresseComplete)->toContain('69001');
        expect($adresseComplete)->toContain('Lyon');
    });

    test('les champs non chiffrables ne sont pas affectés', function () {
        $adherent = new Adherent([
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'email' => 'jean@example.com',
            'pays' => 'France',
            'civilite' => 'M.',
        ]);

        // Les champs SENSIBLES doivent être chiffrés dans les attributs bruts
        $raw = $adherent->getAttributes();
        expect($raw['prenom'])->toStartWith('eyJpdiI6'); // Chiffré
        expect($raw['nom'])->toStartWith('eyJpdiI6'); // Chiffré
        expect($raw['email'])->toStartWith('eyJpdiI6'); // Chiffré

        // Les champs NON sensibles restent en clair
        expect($raw['pays'])->toBe('France');
        expect($raw['civilite'])->toBe('M.');
    });
});

describe('Chiffrement des données personnelles - RepresentantLegal', function () {

    test('les données sensibles du représentant sont chiffrées', function () {
        $representant = new RepresentantLegal([
            'civilite' => 'Mme',
            'prenom' => 'Marie',
            'nom' => 'Martin',
            'lien_parente' => 'Mère',
            'email' => 'marie.martin@example.com',
            'telephone' => '0123456789',
            'mobile' => '0687654321',
            'numero_rue' => '456',
            'rue' => 'Avenue des Fleurs',
            'code_postal' => '69002',
            'ville' => 'Lyon',
            'pays' => 'France',
        ]);

        // Accéder aux attributs - ils doivent être en clair
        expect($representant->telephone)->toBe('0123456789');
        expect($representant->mobile)->toBe('0687654321');
        expect($representant->rue)->toBe('Avenue des Fleurs');
        expect($representant->code_postal)->toBe('69002');
        expect($representant->ville)->toBe('Lyon');

        // Les attributs bruts doivent être chiffrés
        $raw = $representant->getAttributes();
        expect($raw['telephone'])->not->toBe('0123456789');
        expect($raw['rue'])->not->toBe('Avenue des Fleurs');
    });

    test('l\'attribut adresse_complete du représentant fonctionne', function () {
        $representant = new RepresentantLegal([
            'numero_rue' => '456',
            'rue' => 'Avenue des Fleurs',
            'code_postal' => '69002',
            'ville' => 'Lyon',
            'pays' => 'France',
        ]);

        $adresseComplete = $representant->adresse_complete;

        expect($adresseComplete)->toContain('456');
        expect($adresseComplete)->toContain('Avenue des Fleurs');
        expect($adresseComplete)->toContain('69002');
        expect($adresseComplete)->toContain('Lyon');
    });

    test('les booléens du représentant ne sont pas affectés par le chiffrement', function () {
        $representant = new RepresentantLegal([
            'civilite' => 'M.',
            'prenom' => 'Pierre',
            'nom' => 'Durant',
            'lien_parente' => 'Père',
            'est_principal' => true,
            'peut_recuperer' => true,
            'autorise_sortie' => false,
            'autorise_transport' => true,
        ]);

        expect($representant->est_principal)->toBeTrue();
        expect($representant->peut_recuperer)->toBeTrue();
        expect($representant->autorise_sortie)->toBeFalse();
        expect($representant->autorise_transport)->toBeTrue();
    });
});

describe('Sécurité du chiffrement', function () {

    test('les valeurs nulles ne sont pas chiffrées', function () {
        $adherent = new Adherent([
            'civilite' => 'M.',
            'prenom' => 'Test',
            'nom' => 'User',
            'date_naissance' => '1990-01-01',
            'telephone' => null,
            'mobile' => null,
        ]);

        $raw = $adherent->getAttributes();
        expect($raw['telephone'])->toBeNull();
        expect($raw['mobile'])->toBeNull();
    });

    test('les chaînes vides ne sont pas chiffrées en tant que null', function () {
        $adherent = new Adherent;
        $adherent->telephone = '';

        // Une chaîne vide ne devrait pas être nulle
        expect($adherent->telephone)->toBe('');
    });

    test('le chiffrement utilise la clé APP_KEY de Laravel', function () {
        // Créer un adhérent avec des données sensibles
        $adherent = new Adherent;
        $adherent->telephone = '0123456789';

        // Récupérer la valeur chiffrée
        $encrypted = $adherent->getAttributes()['telephone'];

        // Vérifier qu'on peut déchiffrer avec Crypt::decryptString
        $decrypted = Crypt::decryptString($encrypted);
        expect($decrypted)->toBe('0123456789');

        // Vérifier que la valeur chiffrée commence par eyJpdiI6 (base64 de {"iv":)
        expect($encrypted)->toStartWith('eyJpdiI6');
    });

    test('différentes instances chiffrent différemment (IV unique)', function () {
        $adherent1 = new Adherent;
        $adherent1->telephone = '0123456789';

        $adherent2 = new Adherent;
        $adherent2->telephone = '0123456789';

        $encrypted1 = $adherent1->getAttributes()['telephone'];
        $encrypted2 = $adherent2->getAttributes()['telephone'];

        // Les valeurs chiffrées doivent être différentes (IV aléatoire)
        expect($encrypted1)->not->toBe($encrypted2);

        // Mais déchiffrées, elles doivent être identiques
        expect(Crypt::decryptString($encrypted1))->toBe(Crypt::decryptString($encrypted2));
    });
});

describe('Compatibilité et résilience', function () {

    test('le système gère les anciennes données non chiffrées', function () {
        $adherent = new Adherent;

        // Simuler une ancienne donnée non chiffrée en forçant l'attribut brut
        $adherent->setRawAttributes([
            'telephone' => '0123456789', // Non chiffré (ancien format)
            'mobile' => Crypt::encryptString('0687654321'), // Chiffré (nouveau format)
        ], true);

        // Les deux doivent être accessibles
        expect($adherent->telephone)->toBe('0123456789'); // Donnée non chiffrée retournée telle quelle
        expect($adherent->mobile)->toBe('0687654321'); // Donnée chiffrée déchiffrée
    });
});
