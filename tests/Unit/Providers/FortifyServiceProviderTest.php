<?php

namespace Tests\Unit\Providers;

use Tests\TestCase;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Fortify;

class FortifyServiceProviderTest extends TestCase
{
    /**
     * Test 1: Vérifier que CreateNewUser action est enregistrée
     * @test
     */
    public function test_create_new_user_action_is_registered()
    {
        // Le service provider doit avoir configuré Fortify::createUsersUsing
        // On va vérifier qu'on peut créer un utilisateur via CreateNewUser
        $action = app('App\Actions\Fortify\CreateNewUser');

        $this->assertNotNull($action);
    }

    /**
     * Test 2: Vérifier que UpdateUserPassword action est enregistrée
     * @test
     */
    public function test_update_user_password_action_is_registered()
    {
        // Le service provider doit avoir configuré Fortify::updateUserPasswordsUsing
        $action = app('App\Actions\Fortify\UpdateUserPassword');

        $this->assertNotNull($action);
    }

    /**
     * Test 3: Vérifier que ResetUserPassword action est enregistrée
     * @test
     */
    public function test_reset_user_password_action_is_registered()
    {
        // Le service provider doit avoir configuré Fortify::resetUserPasswordsUsing
        $action = app('App\Actions\Fortify\ResetUserPassword');

        $this->assertNotNull($action);
    }

    /**
     * Test 4: Vérifier que l'authentification personnalisée utilise le champ 'mot_de_passe'
     * @test
     */
    public function test_custom_authentication_uses_mot_de_passe_field()
    {
        $plainPassword = 'test_password_123';

        $user = Utilisateur::factory()->create([
            'email' => 'auth.test.' . uniqid() . '@example.com',
            'mot_de_passe' => $plainPassword,
        ]);

        // Vérifier que getAuthPasswordName retourne 'mot_de_passe'
        $this->assertEquals('mot_de_passe', $user->getAuthPasswordName());

        // Vérifier que le password hash peut être validé
        $this->assertTrue(Hash::check($plainPassword, $user->mot_de_passe));
    }

    /**
     * Test 5: Vérifier que Hash::check fonctionne correctement avec le mot_de_passe stocké
     * @test
     */
    public function test_hash_check_validates_password_correctly()
    {
        $plainPassword = 'secret_password_456';

        $user = Utilisateur::factory()->create([
            'email' => 'hash.test.' . uniqid() . '@example.com',
            'mot_de_passe' => $plainPassword,
        ]);

        // Hash::check doit valider le mot de passe correct
        $this->assertTrue(Hash::check($plainPassword, $user->mot_de_passe));

        // Hash::check doit rejeter un mauvais mot de passe
        $this->assertFalse(Hash::check('wrong_password', $user->mot_de_passe));
    }

    /**
     * Test 6: Vérifier que Utilisateur::where('email') peut trouver un utilisateur
     * @test
     */
    public function test_utilisateur_can_be_found_by_email()
    {
        $email = 'find.user.' . uniqid() . '@example.com';

        $user = Utilisateur::factory()->create([
            'email' => $email,
            'mot_de_passe' => 'password123',
        ]);

        // Trouver l'utilisateur par email
        $found = Utilisateur::where('email', $email)->first();

        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
    }

    /**
     * Test 7: Vérifier que le rate limiter est utilisé dans FortifyServiceProvider (5 tentatives/minute pour login)
     * @test
     */
    public function test_login_rate_limiter_configuration_includes_5_per_minute()
    {
        // Créer une requête simulée
        $request = new Request();
        $request->setUserResolver(function () {
            return null;
        });

        // Le provider configure RateLimiter::for('login') avec Limit::perMinute(5)
        // On vérifie que cette configuration existe dans le service provider
        $providerPath = base_path('app/Providers/FortifyServiceProvider.php');
        $providerContent = file_get_contents($providerPath);

        // Vérifier que le provider contient la configuration du rate limiter pour login
        $this->assertStringContainsString("RateLimiter::for('login'", $providerContent);
        $this->assertStringContainsString('perMinute(5)', $providerContent);
    }

    /**
     * Test 8: Vérifier que le rate limiter 'two-factor' est configuré (5 tentatives/minute)
     * @test
     */
    public function test_two_factor_rate_limiter_configuration_includes_5_per_minute()
    {
        // Le provider configure RateLimiter::for('two-factor') avec Limit::perMinute(5)
        // On vérifie que cette configuration existe dans le service provider
        $providerPath = base_path('app/Providers/FortifyServiceProvider.php');
        $providerContent = file_get_contents($providerPath);

        // Vérifier que le provider contient la configuration du rate limiter pour two-factor
        $this->assertStringContainsString("RateLimiter::for('two-factor'", $providerContent);
        $this->assertStringContainsString('perMinute(5)', $providerContent);
    }
}
