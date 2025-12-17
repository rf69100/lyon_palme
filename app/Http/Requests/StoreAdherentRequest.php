<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdherentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization is handled by controller middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'civilite' => ['required', 'string', 'in:M.,Mme,Autre'],
            'prenom' => ['required', 'string', 'max:100'],
            'nom' => ['required', 'string', 'max:100'],
            'date_naissance' => ['required', 'date', 'before:today'],
            'email' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'numero_rue' => ['nullable', 'string', 'max:10'],
            'rue' => ['nullable', 'string', 'max:255'],
            'complement_adresse' => ['nullable', 'string', 'max:255'],
            'code_postal' => ['nullable', 'string', 'max:10'],
            'ville' => ['nullable', 'string', 'max:100'],
            'statut' => ['required', 'string', 'in:actif,inactif,radie'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'civilite.required' => 'La civilité est obligatoire.',
            'civilite.in' => 'La civilité doit être M., Mme ou Autre.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.max' => 'Le prénom ne peut pas dépasser :max caractères.',
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser :max caractères.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser :max caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser :max caractères.',
            'mobile.max' => 'Le numéro de mobile ne peut pas dépasser :max caractères.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut doit être actif, inactif ou radié.',
        ];
    }
}
