<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use Illuminate\Support\Facades\Crypt;
use App\Models\Adherent;
use App\Models\RepresentantLegal;
use App\Models\CertificatMedical;

class EncryptsAttributesTest extends TestCase
{
    protected Adherent $adherent;
    protected RepresentantLegal $representantLegal;
    protected CertificatMedical $certificatMedical;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un adhérent pour les tests
        $this->adherent = Adherent::factory()->create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@example.com',
        ]);

        // Créer un représentant légal pour les tests
        $this->representantLegal = RepresentantLegal::factory()->create([
            'nom' => 'Martin',
            'prenom' => 'Marie',
        ]);

        // Créer un certificat médical pour les tests
        $this->certificatMedical = CertificatMedical::factory()->create([
            'nom_medecin' => 'Dr. Lefevre',
        ]);
    }

    /**
     * Test 1: Vérifier que les attributs chiffrables sont bien chiffrés en base de données
     * @test
     */
    public function test_attributes_are_encrypted_in_database()
    {
        // Récupérer la valeur directement de la base de données
        $rawData = \DB::table('adherents')
            ->where('id', $this->adherent->id)
            ->first();

        // Vérifier que 'nom' est chiffré en base (commence par "eyJpdiI6")
        $this->assertTrue($this->isEncrypted($rawData->nom), 'nom should be encrypted in database');

        // Vérifier que 'prenom' est chiffré
        $this->assertTrue($this->isEncrypted($rawData->prenom), 'prenom should be encrypted in database');

        // Vérifier que 'email' est chiffré
        $this->assertTrue($this->isEncrypted($rawData->email), 'email should be encrypted in database');
    }

    /**
     * Test 2: Vérifier que les attributs sont déchiffrés lors de la lecture
     * @test
     */
    public function test_attributes_are_decrypted_on_read()
    {
        // Récupérer l'adhérent depuis la base de données
        $adherent = Adherent::find($this->adherent->id);

        // Vérifier que les attributs sont déchiffrés
        $this->assertEquals('Dupont', $adherent->nom);
        $this->assertEquals('Jean', $adherent->prenom);
        $this->assertEquals('jean.dupont@example.com', $adherent->email);
    }

    /**
     * Test 3: Tester la détection d'attributs déjà chiffrés (prévention double chiffrement)
     * @test
     */
    public function test_already_encrypted_attributes_are_not_reencrypted()
    {
        // Récupérer l'adhérent
        $adherent = Adherent::find($this->adherent->id);

        // Récupérer la valeur chiffrée en base
        $rawData = \DB::table('adherents')
            ->where('id', $adherent->id)
            ->first();
        $firstEncryption = $rawData->nom;

        // Sauvegarder l'adhérent (sans le modifier)
        $adherent->save();

        // Récupérer la valeur chiffrée après sauvegarde
        $rawDataAfter = \DB::table('adherents')
            ->where('id', $adherent->id)
            ->first();
        $secondValue = $rawDataAfter->nom;

        // Les deux valeurs chiffrées doivent être identiques (pas re-chiffrement)
        $this->assertEquals($firstEncryption, $secondValue, 'Encrypted value should not change on re-save');
    }

    /**
     * Test 4: Vérifier que les valeurs nulles ne sont pas chiffrées
     * @test
     */
    public function test_null_values_are_not_encrypted()
    {
        $adherent = Adherent::factory()->create([
            'telephone' => null,
        ]);

        // Vérifier que la valeur en base est NULL, pas chiffrée
        $rawData = \DB::table('adherents')
            ->where('id', $adherent->id)
            ->first();

        $this->assertNull($rawData->telephone);
    }

    /**
     * Test 5: Vérifier que les chaînes vides restent vides
     * @test
     */
    public function test_empty_strings_are_not_encrypted()
    {
        $adherent = Adherent::factory()->create([
            'telephone' => '',
        ]);

        // Récupérer depuis la base
        $adherent = Adherent::find($adherent->id);
        $this->assertEquals('', $adherent->telephone);
    }

    /**
     * Test 6: Tester la génération des champs de recherche hashés pour 'nom'
     * @test
     */
    public function test_search_field_generated_for_nom()
    {
        $adherent = Adherent::factory()->create([
            'nom' => 'Dupont',
        ]);

        // Récupérer depuis la base
        $rawData = \DB::table('adherents')
            ->where('id', $adherent->id)
            ->first();

        // Vérifier que nom_recherche est un hash SHA256
        $expectedHash = hash('sha256', mb_strtolower('Dupont'));
        $this->assertEquals($expectedHash, $rawData->nom_recherche);
    }

    /**
     * Test 7: Tester la génération des champs de recherche hashés pour 'prenom'
     * @test
     */
    public function test_search_field_generated_for_prenom()
    {
        $adherent = Adherent::factory()->create([
            'prenom' => 'Jean',
        ]);

        // Récupérer depuis la base
        $rawData = \DB::table('adherents')
            ->where('id', $adherent->id)
            ->first();

        // Vérifier que prenom_recherche est un hash SHA256
        $expectedHash = hash('sha256', mb_strtolower('Jean'));
        $this->assertEquals($expectedHash, $rawData->prenom_recherche);
    }

    /**
     * Test 8: Tester la génération du champ nom_complet_recherche
     * @test
     */
    public function test_search_field_generated_for_nom_complet()
    {
        $adherent = Adherent::factory()->create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
        ]);

        // Récupérer depuis la base
        $rawData = \DB::table('adherents')
            ->where('id', $adherent->id)
            ->first();

        // Vérifier que nom_complet_recherche est un hash SHA256 du nom complet
        $expectedHash = hash('sha256', mb_strtolower('Dupont Jean'));
        $this->assertEquals($expectedHash, $rawData->nom_complet_recherche);
    }

    /**
     * Test 9: Tester la compatibilité avec les anciennes données non chiffrées
     * @test
     */
    public function test_fallback_to_unencrypted_data()
    {
        // Créer un adhérent
        $adherent = Adherent::factory()->create();

        // Simuler des données non chiffrées en base (données legacy)
        \DB::table('adherents')
            ->where('id', $adherent->id)
            ->update([
                'nom' => 'DonneeNonChiffree',
                'prenom' => 'Legacy',
            ]);

        // Récupérer l'adhérent
        $adherent = Adherent::find($adherent->id);

        // Vérifier que les données legacy sont retournées telles quelles
        $this->assertEquals('DonneeNonChiffree', $adherent->nom);
        $this->assertEquals('Legacy', $adherent->prenom);
    }

    /**
     * Test 10: Vérifier que IV est aléatoire (deux chiffrements du même texte donnent des résultats différents)
     * @test
     */
    public function test_iv_is_random()
    {
        // Créer deux adhérents avec le même nom
        $adherent1 = Adherent::factory()->create(['nom' => 'TestNom']);
        $adherent2 = Adherent::factory()->create(['nom' => 'TestNom']);

        // Récupérer les valeurs chiffrées
        $raw1 = \DB::table('adherents')->where('id', $adherent1->id)->first()->nom;
        $raw2 = \DB::table('adherents')->where('id', $adherent2->id)->first()->nom;

        // Les deux valeurs chiffrées doivent être différentes (IV aléatoire)
        $this->assertNotEquals($raw1, $raw2, 'Encrypted values should differ due to random IV');
    }

    /**
     * Test 11: Tester la conversion DateTime avant chiffrement
     * @test
     */
    public function test_datetime_conversion_before_encryption()
    {
        $date = now();
        $certificat = CertificatMedical::factory()->create([
            'delivre_le' => $date,
        ]);

        // Récupérer depuis la base
        $certificat = CertificatMedical::find($certificat->id);

        // Vérifier que la date peut être comparée
        $this->assertTrue($certificat->delivre_le instanceof \DateTime);
    }

    /**
     * Test 12: Tester que les données de santé sont chiffrées (CertificatMedical - RGPD Art. 9)
     * @test
     */
    public function test_health_data_is_encrypted()
    {
        $certificat = CertificatMedical::factory()->create([
            'nom_medecin' => 'Dr. Lefevre',
            'numero_ordre_medecin' => '12345',
            'restrictions' => 'Aucune plongée en profondeur',
        ]);

        // Vérifier que ces données sont chiffrées en base
        $rawData = \DB::table('certificats_medicaux')
            ->where('id', $certificat->id)
            ->first();

        $this->assertTrue($this->isEncrypted($rawData->nom_medecin));
        $this->assertTrue($this->isEncrypted($rawData->numero_ordre_medecin));
        $this->assertTrue($this->isEncrypted($rawData->restrictions));
    }

    /**
     * Test 13: Tester que les données des représentants légaux sont chiffrées
     * @test
     */
    public function test_representant_legal_data_is_encrypted()
    {
        $repr = RepresentantLegal::factory()->create([
            'nom' => 'Martin',
            'prenom' => 'Marie',
            'email' => 'marie.martin@example.com',
            'mobile' => '0612345678',
        ]);

        // Vérifier que ces données sont chiffrées en base
        $rawData = \DB::table('representants_legaux')
            ->where('id', $repr->id)
            ->first();

        $this->assertTrue($this->isEncrypted($rawData->nom));
        $this->assertTrue($this->isEncrypted($rawData->prenom));
        $this->assertTrue($this->isEncrypted($rawData->email));
        $this->assertTrue($this->isEncrypted($rawData->mobile));
    }

    /**
     * Test 14: Tester que attributesToArray déchiffre les attributs
     * @test
     */
    public function test_attributes_to_array_decrypts_values()
    {
        $adherent = Adherent::factory()->create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
        ]);

        // Récupérer sous forme de tableau
        $array = $adherent->toArray();

        // Vérifier que les valeurs sont déchiffrées dans le tableau
        $this->assertEquals('Dupont', $array['nom']);
        $this->assertEquals('Jean', $array['prenom']);
    }

    /**
     * Test 15: Tester la décryption via Crypt::decryptString
     * @test
     */
    public function test_encryption_is_compatible_with_crypt_facade()
    {
        // Créer un adhérent
        $adherent = Adherent::factory()->create([
            'nom' => 'TestDecrypt',
        ]);

        // Récupérer la valeur chiffrée directement de la base
        $encrypted = \DB::table('adherents')
            ->where('id', $adherent->id)
            ->first()->nom;

        // Déchiffrer via Crypt::decryptString
        $decrypted = Crypt::decryptString($encrypted);

        // Vérifier que c'est correct
        $this->assertEquals('TestDecrypt', $decrypted);
    }

    /**
     * Test 16: Tester shouldEncrypt() retourne true/false correct
     * @test
     */
    public function test_should_encrypt_method_works_correctly()
    {
        $adherent = new Adherent();

        // Les attributs chiffrables doivent retourner true
        // Utiliser la réflexion pour accéder à la méthode protected
        $reflection = new \ReflectionMethod($adherent, 'shouldEncrypt');
        $reflection->setAccessible(true);

        // Tester un attribut chiffrable
        $this->assertTrue($reflection->invoke($adherent, 'nom'));

        // Tester un attribut non-chiffrable
        $this->assertFalse($reflection->invoke($adherent, 'id'));
    }

    /**
     * Test 17: Tester getEncryptableAttributes() retourne le bon array
     * @test
     */
    public function test_get_encryptable_attributes_returns_array()
    {
        $adherent = new Adherent();

        // Utiliser la réflexion pour accéder à la méthode protected
        $reflection = new \ReflectionMethod($adherent, 'getEncryptableAttributes');
        $reflection->setAccessible(true);

        $encryptable = $reflection->invoke($adherent);

        // Vérifier que c'est un array
        $this->assertIsArray($encryptable);

        // Vérifier que les attributs critiques sont là
        $this->assertContains('nom', $encryptable);
        $this->assertContains('prenom', $encryptable);
        $this->assertContains('email', $encryptable);
    }

    /**
     * Test 18: Tester isEncrypted() détecte correctement une valeur chiffrée
     * @test
     */
    public function test_is_encrypted_detects_encrypted_values()
    {
        $adherent = new Adherent();

        // Utiliser la réflexion pour accéder à la méthode protected
        $reflection = new \ReflectionMethod($adherent, 'isEncrypted');
        $reflection->setAccessible(true);

        // Une valeur chiffrée commence par "eyJpdiI6" (base64 du JSON)
        $encrypted = Crypt::encryptString('test');
        $this->assertTrue($reflection->invoke($adherent, $encrypted));

        // Une valeur non chiffrée ne commence pas par "eyJpdiI6"
        $this->assertFalse($reflection->invoke($adherent, 'plaintext'));
    }

    /**
     * Méthode helper: Vérifier si une valeur est chiffrée
     */
    private function isEncrypted($value): bool
    {
        if (is_null($value)) {
            return false;
        }

        // Une valeur chiffrée Laravel commence par "eyJpdiI6" (base64)
        return str_starts_with($value, 'eyJpdiI6');
    }
}
