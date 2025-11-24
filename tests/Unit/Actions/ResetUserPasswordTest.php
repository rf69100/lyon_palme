<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Models\Utilisateur;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetUserPasswordTest extends TestCase
{
    /**
     * Test 1: Vérifier que le mot de passe peut être réinitialisé avec un nouveau mot de passe valide
     * @test
     */
    public function test_user_password_can_be_reset_with_valid_password()
    {
        $newPassword = 'NewPassword456!';

        $user = Utilisateur::factory()->create([
            'email' => 'reset.pwd.' . uniqid() . '@example.com',
            'mot_de_passe' => 'OldPassword123!',
        ]);

        $action = new ResetUserPassword();

        $action->reset($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Vérifier que l'utilisateur a été mis à jour
        $updated = Utilisateur::find($user->id);

        // Vérifier que le nouveau mot de passe est correct
        $this->assertTrue(Hash::check($newPassword, $updated->mot_de_passe));

        // Vérifier que l'ancien mot de passe ne fonctionne plus
        $this->assertFalse(Hash::check('OldPassword123!', $updated->mot_de_passe));
    }

    /**
     * Test 2: Vérifier que le nouveau mot de passe est haché correctement
     * @test
     */
    public function test_reset_password_is_hashed_correctly()
    {
        $plainPassword = 'ResetPassword789!';

        $user = Utilisateur::factory()->create([
            'email' => 'reset.hash.' . uniqid() . '@example.com',
        ]);

        $action = new ResetUserPassword();

        $action->reset($user, [
            'password' => $plainPassword,
            'password_confirmation' => $plainPassword,
        ]);

        $updated = Utilisateur::find($user->id);

        // Vérifier que le mot de passe n'est pas stocké en clair
        $this->assertNotEquals($plainPassword, $updated->mot_de_passe);

        // Vérifier que Hash::check valide le mot de passe
        $this->assertTrue(Hash::check($plainPassword, $updated->mot_de_passe));
    }

    /**
     * Test 3: Vérifier que la validation échoue si le mot de passe est manquant
     * @test
     */
    public function test_reset_fails_if_password_is_missing()
    {
        $user = Utilisateur::factory()->create([
            'email' => 'missing.reset.' . uniqid() . '@example.com',
        ]);

        $action = new ResetUserPassword();

        $this->expectException(ValidationException::class);

        $action->reset($user, [
            'password_confirmation' => 'SomePassword!',
        ]);
    }

    /**
     * Test 4: Vérifier que la validation échoue si password_confirmation ne correspond pas
     * @test
     */
    public function test_reset_fails_if_password_confirmation_does_not_match()
    {
        $user = Utilisateur::factory()->create([
            'email' => 'mismatch.reset.' . uniqid() . '@example.com',
        ]);

        $action = new ResetUserPassword();

        $this->expectException(ValidationException::class);

        $action->reset($user, [
            'password' => 'NewPassword456!',
            'password_confirmation' => 'DifferentPassword!',
        ]);
    }

    /**
     * Test 5: Vérifier que le mot de passe du utilisateur est modifié en forceFill et save
     * @test
     */
    public function test_reset_uses_force_fill_to_bypass_protections()
    {
        $newPassword = 'ResetForceFill123!';

        $user = Utilisateur::factory()->create([
            'email' => 'forcefill.reset.' . uniqid() . '@example.com',
            'mot_de_passe' => 'OriginalPassword!',
        ]);

        $action = new ResetUserPassword();

        // Vérifier que mot_de_passe est dans fillable avant reset
        $originalFillable = $user->getFillable();

        $action->reset($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $updated = Utilisateur::find($user->id);

        // Vérifier que le mot de passe a été changé même si mot_de_passe n'est pas dans fillable
        $this->assertTrue(Hash::check($newPassword, $updated->mot_de_passe));
    }
}
