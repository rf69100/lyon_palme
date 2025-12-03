<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        // CNIL recommendations: min 12 chars, uppercase, lowercase, digits, special chars
        return [
            'required',
            'string',
            Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols(),
            'confirmed',
        ];
    }
}
