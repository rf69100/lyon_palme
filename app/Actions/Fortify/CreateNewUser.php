<?php

namespace App\Actions\Fortify;

use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): Utilisateur
    {
        Validator::make($input, [
            'nom' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Utilisateur::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return Utilisateur::create([
            'nom' => $input['nom'],
            'email' => $input['email'],
            'mot_de_passe' => Hash::make($input['password']),
        ]);
    }
}
