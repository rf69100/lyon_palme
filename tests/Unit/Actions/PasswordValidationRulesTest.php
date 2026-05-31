<?php

namespace Tests\Unit\Actions;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Validation\Rules\Password;
use Tests\TestCase;

class PasswordValidationRulesTest extends TestCase
{
    use PasswordValidationRules;

    /**
     * Test 1: Vérifier que passwordRules() retourne un array
     *
     * @test
     */
    public function test_password_rules_returns_array()
    {
        $rules = $this->passwordRules();

        $this->assertIsArray($rules);
    }

    /**
     * Test 2: Vérifier que 'required' est dans les règles
     *
     * @test
     */
    public function test_password_rules_includes_required()
    {
        $rules = $this->passwordRules();

        $this->assertContains('required', $rules);
    }

    /**
     * Test 3: Vérifier que 'string' est dans les règles
     *
     * @test
     */
    public function test_password_rules_includes_string()
    {
        $rules = $this->passwordRules();

        $this->assertContains('string', $rules);
    }

    /**
     * Test 4: Vérifier que 'confirmed' est dans les règles
     *
     * @test
     */
    public function test_password_rules_includes_confirmed()
    {
        $rules = $this->passwordRules();

        $this->assertContains('confirmed', $rules);
    }

    /**
     * Test 5: Vérifier que Password::default() est inclus
     *
     * @test
     */
    public function test_password_rules_includes_password_default()
    {
        $rules = $this->passwordRules();

        $hasPasswordRule = false;
        foreach ($rules as $rule) {
            if ($rule instanceof Password) {
                $hasPasswordRule = true;
                break;
            }
        }

        $this->assertTrue($hasPasswordRule, 'Password::default() rule should be included');
    }

    /**
     * Test 6: Vérifier qu'un mot de passe valide passe la validation
     *
     * @test
     */
    public function test_valid_password_passes_validation()
    {
        $rules = $this->passwordRules();

        // CNIL policy requiert au minimum:
        // - 12 caractères
        // - au moins une lettre majuscule
        // - au moins une lettre minuscule
        // - au moins un chiffre
        // - au moins un caractère spécial
        $validPassword = 'ValidPassword123!';

        $validator = \Validator::make([
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
        ], [
            'password' => $rules,
        ]);

        $this->assertTrue($validator->passes(), 'Valid password should pass validation');
    }

    /**
     * Test 7: Vérifier qu'un mot de passe faible échoue la validation
     *
     * @test
     */
    public function test_weak_password_fails_validation()
    {
        $rules = $this->passwordRules();

        // Mot de passe trop faible (< 8 caractères, pas de chiffre, etc.)
        $weakPassword = 'weak';

        $validator = \Validator::make([
            'password' => $weakPassword,
            'password_confirmation' => $weakPassword,
        ], [
            'password' => $rules,
        ]);

        $this->assertTrue($validator->fails(), 'Weak password should fail validation');
    }
}
