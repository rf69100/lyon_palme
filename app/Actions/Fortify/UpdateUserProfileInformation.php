<?php

namespace App\Actions\Fortify;

use App\Models\Utilisateur;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(Utilisateur $user, array $input): void
    {
        Validator::make($input, [
            'nom' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('utilisateurs')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'nom' => $input['nom'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(Utilisateur $user, array $input): void
    {
        $user->forceFill([
            'nom' => $input['nom'],
            'email' => $input['email'],
            'email_verifie_le' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
