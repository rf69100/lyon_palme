<?php

namespace Tests\Unit\Actions;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateNewUserTest extends TestCase
{
    /**
     * Test 1: Vérifier qu'un nouvel utilisateur peut être créé avec des données valides
     *
     * @test
     */
    public function test_create_new_user_with_valid_data()
    {
        $action = new CreateNewUser;

        $input = [
            'nom' => 'Dupont Jean',
            'email' => 'dupont.jean.'.uniqid().'@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        $user = $action->create($input);

        $this->assertNotNull($user->id);
        $this->assertEquals('Dupont Jean', $user->nom);
        $this->assertEquals($input['email'], $user->email);
    }

    /**
     * Test 2: Vérifier que le mot de passe est hashé correctement
     *
     * @test
     */
    public function test_password_is_hashed_when_creating_user()
    {
        $action = new CreateNewUser;

        $plainPassword = 'TestPassword456!';
        $input = [
            'nom' => 'Test User',
            'email' => 'test.hash.'.uniqid().'@example.com',
            'password' => $plainPassword,
            'password_confirmation' => $plainPassword,
        ];

        $user = $action->create($input);

        // Vérifier que le mot de passe est hashé (pas du plain text)
        $this->assertNotEquals($plainPassword, $user->mot_de_passe);

        // Vérifier que Hash::check valide le mot de passe
        $this->assertTrue(Hash::check($plainPassword, $user->mot_de_passe));
    }

    /**
     * Test 3: Vérifier que la validation échoue si nom est manquant
     *
     * @test
     */
    public function test_validation_fails_if_nom_is_missing()
    {
        $action = new CreateNewUser;

        $input = [
            'email' => 'test.'.uniqid().'@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        $this->expectException(ValidationException::class);

        $action->create($input);
    }

    /**
     * Test 4: Vérifier que la validation échoue si email est manquant
     *
     * @test
     */
    public function test_validation_fails_if_email_is_missing()
    {
        $action = new CreateNewUser;

        $input = [
            'nom' => 'Test User',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        $this->expectException(ValidationException::class);

        $action->create($input);
    }

    /**
     * Test 5: Vérifier que la validation échoue si password est manquant
     *
     * @test
     */
    public function test_validation_fails_if_password_is_missing()
    {
        $action = new CreateNewUser;

        $input = [
            'nom' => 'Test User',
            'email' => 'test.'.uniqid().'@example.com',
            'password_confirmation' => 'SomePassword!',
        ];

        $this->expectException(ValidationException::class);

        $action->create($input);
    }

    /**
     * Test 6: Vérifier que la validation échoue si l'email n'est pas unique
     *
     * @test
     */
    public function test_validation_fails_if_email_not_unique()
    {
        $action = new CreateNewUser;

        $email = 'unique.test.'.uniqid().'@example.com';

        // Créer le premier utilisateur
        $action->create([
            'nom' => 'User One',
            'email' => $email,
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ]);

        // Essayer de créer un deuxième avec le même email
        $this->expectException(ValidationException::class);

        $action->create([
            'nom' => 'User Two',
            'email' => $email,
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ]);
    }

    /**
     * Test 7: Vérifier que la validation échoue si password_confirmation ne correspond pas
     *
     * @test
     */
    public function test_validation_fails_if_password_confirmation_does_not_match()
    {
        $action = new CreateNewUser;

        $input = [
            'nom' => 'Test User',
            'email' => 'test.'.uniqid().'@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'DifferentPassword!',
        ];

        $this->expectException(ValidationException::class);

        $action->create($input);
    }

    /**
     * Test 8: Vérifier que la validation échoue si email n'est pas un format valide
     *
     * @test
     */
    public function test_validation_fails_if_email_format_invalid()
    {
        $action = new CreateNewUser;

        $input = [
            'nom' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        $this->expectException(ValidationException::class);

        $action->create($input);
    }

    /**
     * Test 9: Vérifier que la validation échoue si nom dépasse 255 caractères
     *
     * @test
     */
    public function test_validation_fails_if_nom_exceeds_255_characters()
    {
        $action = new CreateNewUser;

        $input = [
            'nom' => str_repeat('a', 256),
            'email' => 'test.'.uniqid().'@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        $this->expectException(ValidationException::class);

        $action->create($input);
    }
}
