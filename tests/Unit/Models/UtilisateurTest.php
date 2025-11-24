<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class UtilisateurTest extends TestCase
{
    /**
     * Test 1: Vérifier qu'un Utilisateur peut être créé avec une password hashée
     * @test
     */
    public function test_utilisateur_can_be_created_with_hashed_password()
    {
        $user = Utilisateur::factory()->create([
            'nom' => 'Dupont Jean',
            'email' => 'jean.dupont.' . uniqid() . '@example.com',
            'mot_de_passe' => 'password123',
        ]);

        // Vérifier que l'utilisateur existe
        $this->assertNotNull($user->id);

        // Vérifier que le mot de passe est hashé (ne commence pas par plain text)
        $this->assertNotEquals('password123', $user->mot_de_passe);

        // Vérifier que le hash peut être comparé avec Hash::check
        $this->assertTrue(Hash::check('password123', $user->mot_de_passe));
    }

    /**
     * Test 2: Vérifier que la cast 'hashed' s'applique automatiquement
     * @test
     */
    public function test_password_cast_automatically_hashes()
    {
        $user = Utilisateur::factory()->create();

        // Récupérer directement de la base (avant Laravel hash cast)
        $rawData = \DB::table('utilisateurs')
            ->where('id', $user->id)
            ->first();

        // Vérifier que la valeur en base est hashée
        $this->assertNotEquals('password', $rawData->mot_de_passe);

        // Vérifier que c'est un hash bcrypt (commence par $2)
        $this->assertTrue(str_starts_with($rawData->mot_de_passe, '$2'));
    }

    /**
     * Test 3: Vérifier que getAuthPasswordName retourne 'mot_de_passe'
     * @test
     */
    public function test_get_auth_password_name_returns_mot_de_passe()
    {
        $user = Utilisateur::factory()->create();

        $this->assertEquals('mot_de_passe', $user->getAuthPasswordName());
    }

    /**
     * Test 4: Vérifier que getRememberTokenName retourne 'jeton_souvenir'
     * @test
     */
    public function test_get_remember_token_name_returns_jeton_souvenir()
    {
        $user = Utilisateur::factory()->create();

        $this->assertEquals('jeton_souvenir', $user->getRememberTokenName());
    }

    /**
     * Test 5: Vérifier que le jeton_souvenir est généré et sauvegardé
     * @test
     */
    public function test_remember_token_is_generated_and_saved()
    {
        $user = Utilisateur::factory()->create();

        // Sauvegarder le token
        $user->setRememberToken('test_token_123');
        $user->save();

        // Vérifier que le token est sauvegardé
        $updated = Utilisateur::find($user->id);
        $this->assertEquals('test_token_123', $updated->jeton_souvenir);

        // Vérifier que le token est retourné par getRememberToken
        $this->assertEquals('test_token_123', $updated->getRememberToken());
    }

    /**
     * Test 6: Vérifier que email_verifie_le peut être un timestamp ou null
     * @test
     */
    public function test_email_verified_at_can_be_timestamp_or_null()
    {
        // Créer avec email vérifié
        $userVerified = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $this->assertNotNull($userVerified->email_verifie_le);
        $this->assertInstanceOf(\DateTime::class, $userVerified->email_verifie_le);

        // Créer avec email non vérifié
        $userNotVerified = Utilisateur::factory()->create([
            'email_verifie_le' => null,
        ]);

        $this->assertNull($userNotVerified->email_verifie_le);
    }

    /**
     * Test 7: Vérifier que doit_changer_mdp est un booléen
     * @test
     */
    public function test_doit_changer_mdp_is_boolean()
    {
        $userTrue = Utilisateur::factory()->create([
            'doit_changer_mdp' => true,
        ]);

        $this->assertTrue($userTrue->doit_changer_mdp);
        $this->assertIsBool($userTrue->doit_changer_mdp);

        $userFalse = Utilisateur::factory()->create([
            'doit_changer_mdp' => false,
        ]);

        $this->assertFalse($userFalse->doit_changer_mdp);
        $this->assertIsBool($userFalse->doit_changer_mdp);
    }

    /**
     * Test 8: Vérifier que mot_de_passe est caché dans les arrays et JSON
     * @test
     */
    public function test_password_is_hidden_in_arrays_and_json()
    {
        $user = Utilisateur::factory()->create([
            'nom' => 'Test User',
            'email' => 'test.' . uniqid() . '@example.com',
        ]);

        // Vérifier que mot_de_passe est caché dans toArray()
        $array = $user->toArray();
        $this->assertArrayNotHasKey('mot_de_passe', $array);

        // Vérifier que jeton_souvenir est caché dans toArray()
        $this->assertArrayNotHasKey('jeton_souvenir', $array);

        // Vérifier que mot_de_passe est caché dans toJson()
        $json = $user->toJson();
        $this->assertStringNotContainsString('mot_de_passe', $json);

        // Les autres champs doivent être présents
        $this->assertStringContainsString('Test User', $json);
        $this->assertStringContainsString($user->email, $json);
    }
}
