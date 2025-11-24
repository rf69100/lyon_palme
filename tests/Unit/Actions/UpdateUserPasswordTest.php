<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Models\Utilisateur;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UpdateUserPasswordTest extends TestCase
{
    /**
     * Test 1: Vérifier que le mot de passe peut être mis à jour avec le bon mot de passe actuel
     * @test
     */
    public function test_user_password_can_be_updated_with_correct_current_password()
    {
        $currentPassword = 'CurrentPassword123!';
        $newPassword = 'NewPassword456!';

        // Créer l'utilisateur avec un mot de passe connu
        $user = Utilisateur::factory()->create([
            'email' => 'update.pwd.' . uniqid() . '@example.com',
            'mot_de_passe' => $currentPassword,
        ]);

        // Authentifier l'utilisateur pour que la validation 'current_password' fonctionne
        Auth::login($user);

        $action = new UpdateUserPassword();

        $action->update($user, [
            'current_password' => $currentPassword,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Vérifier que l'utilisateur a été mis à jour
        $updated = Utilisateur::find($user->id);

        // Vérifier que le nouveau mot de passe est correct
        $this->assertTrue(Hash::check($newPassword, $updated->mot_de_passe));

        // Vérifier que l'ancien mot de passe ne fonctionne plus
        $this->assertFalse(Hash::check($currentPassword, $updated->mot_de_passe));
    }

    /**
     * Test 2: Vérifier que la mise à jour échoue si le mot de passe actuel est incorrect
     * @test
     */
    public function test_update_fails_if_current_password_is_incorrect()
    {
        $user = Utilisateur::factory()->create([
            'email' => 'wrong.pwd.' . uniqid() . '@example.com',
            'mot_de_passe' => 'CorrectPassword123!',
        ]);

        $action = new UpdateUserPassword();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'current_password' => 'WrongPassword!',
            'password' => 'NewPassword456!',
            'password_confirmation' => 'NewPassword456!',
        ]);
    }

    /**
     * Test 3: Vérifier que la mise à jour échoue si le mot de passe actuel est manquant
     * @test
     */
    public function test_update_fails_if_current_password_is_missing()
    {
        $user = Utilisateur::factory()->create([
            'email' => 'missing.curr.' . uniqid() . '@example.com',
            'mot_de_passe' => 'SomePassword123!',
        ]);

        $action = new UpdateUserPassword();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'password' => 'NewPassword456!',
            'password_confirmation' => 'NewPassword456!',
        ]);
    }

    /**
     * Test 4: Vérifier que la mise à jour échoue si le nouveau mot de passe ne correspond pas à confirmation
     * @test
     */
    public function test_update_fails_if_password_confirmation_does_not_match()
    {
        $user = Utilisateur::factory()->create([
            'email' => 'mismatch.conf.' . uniqid() . '@example.com',
            'mot_de_passe' => 'CurrentPassword123!',
        ]);

        $action = new UpdateUserPassword();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'current_password' => 'CurrentPassword123!',
            'password' => 'NewPassword456!',
            'password_confirmation' => 'DifferentPassword!',
        ]);
    }

    /**
     * Test 5: Vérifier que le nouveau mot de passe est haché correctement
     * @test
     */
    public function test_new_password_is_hashed_correctly()
    {
        $currentPassword = 'CurrentPassword123!';
        $plainNewPassword = 'NewPassword789!';

        // Créer l'utilisateur avec un mot de passe connu
        $user = Utilisateur::factory()->create([
            'email' => 'hash.test.' . uniqid() . '@example.com',
            'mot_de_passe' => $currentPassword,
        ]);

        // Authentifier l'utilisateur
        Auth::login($user);

        $action = new UpdateUserPassword();

        $action->update($user, [
            'current_password' => $currentPassword,
            'password' => $plainNewPassword,
            'password_confirmation' => $plainNewPassword,
        ]);

        $updated = Utilisateur::find($user->id);

        // Vérifier que le mot de passe n'est pas stocké en clair
        $this->assertNotEquals($plainNewPassword, $updated->mot_de_passe);

        // Vérifier que Hash::check valide le nouveau mot de passe
        $this->assertTrue(Hash::check($plainNewPassword, $updated->mot_de_passe));
    }

    /**
     * Test 6: Vérifier que la validation échoue si le nouveau mot de passe est manquant
     * @test
     */
    public function test_update_fails_if_new_password_is_missing()
    {
        $user = Utilisateur::factory()->create([
            'email' => 'missing.new.' . uniqid() . '@example.com',
            'mot_de_passe' => 'CurrentPassword123!',
        ]);

        $action = new UpdateUserPassword();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'current_password' => 'CurrentPassword123!',
        ]);
    }
}
