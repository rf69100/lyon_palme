<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Models\Utilisateur;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Validation\ValidationException;

class UpdateUserProfileInformationTest extends TestCase
{
    /**
     * Test 1: Vérifier que le profil peut être mis à jour avec des données valides
     * @test
     */
    public function test_user_profile_can_be_updated_with_valid_data()
    {
        $user = Utilisateur::factory()->create([
            'nom' => 'Old Name',
            'email' => 'old.' . uniqid() . '@example.com',
        ]);

        $action = new UpdateUserProfileInformation();

        $action->update($user, [
            'nom' => 'New Name',
            'email' => 'new.' . uniqid() . '@example.com',
        ]);

        $updated = Utilisateur::find($user->id);

        $this->assertEquals('New Name', $updated->nom);
        $this->assertNotEquals('Old Name', $updated->nom);
    }

    /**
     * Test 2: Vérifier que la mise à jour échoue si nom est manquant
     * @test
     */
    public function test_update_fails_if_nom_is_missing()
    {
        $user = Utilisateur::factory()->create();
        $action = new UpdateUserProfileInformation();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'email' => 'test.' . uniqid() . '@example.com',
        ]);
    }

    /**
     * Test 3: Vérifier que la mise à jour échoue si email est manquant
     * @test
     */
    public function test_update_fails_if_email_is_missing()
    {
        $user = Utilisateur::factory()->create();
        $action = new UpdateUserProfileInformation();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'nom' => 'Some Name',
        ]);
    }

    /**
     * Test 4: Vérifier que la mise à jour échoue si email n'est pas unique (sauf pour l'utilisateur actuel)
     * @test
     */
    public function test_update_fails_if_email_not_unique()
    {
        $existingEmail = 'existing.' . uniqid() . '@example.com';
        $user1 = Utilisateur::factory()->create(['email' => $existingEmail]);
        $user2 = Utilisateur::factory()->create();

        $action = new UpdateUserProfileInformation();

        $this->expectException(ValidationException::class);

        $action->update($user2, [
            'nom' => 'New Name',
            'email' => $existingEmail,
        ]);
    }

    /**
     * Test 5: Vérifier que l'email peut être conservé lors d'une mise à jour
     * @test
     */
    public function test_user_can_keep_same_email()
    {
        $email = 'same.' . uniqid() . '@example.com';
        $user = Utilisateur::factory()->create([
            'nom' => 'Old Name',
            'email' => $email,
        ]);

        $action = new UpdateUserProfileInformation();

        // Pas d'exception: l'utilisateur peut mettre à jour en gardant son email
        $action->update($user, [
            'nom' => 'New Name',
            'email' => $email,
        ]);

        $updated = Utilisateur::find($user->id);
        $this->assertEquals('New Name', $updated->nom);
        $this->assertEquals($email, $updated->email);
    }

    /**
     * Test 6: Vérifier que nom ne dépasse pas 255 caractères
     * @test
     */
    public function test_update_fails_if_nom_exceeds_255_characters()
    {
        $user = Utilisateur::factory()->create();
        $action = new UpdateUserProfileInformation();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'nom' => str_repeat('a', 256),
            'email' => 'test.' . uniqid() . '@example.com',
        ]);
    }

    /**
     * Test 7: Vérifier que email doit être un format valide
     * @test
     */
    public function test_update_fails_if_email_format_invalid()
    {
        $user = Utilisateur::factory()->create();
        $action = new UpdateUserProfileInformation();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'nom' => 'Valid Name',
            'email' => 'not-an-email',
        ]);
    }
}
