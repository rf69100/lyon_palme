<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdherentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // L'autorisation est gérée par le middleware "admin" du groupe de routes.
        return true;
    }

    /**
     * Calcule le statut mineur à partir de la date de naissance pour piloter
     * les règles conditionnelles (représentant légal, autorisation parentale).
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('date_naissance')) {
            try {
                $estMineur = Carbon::parse($this->input('date_naissance'))->age < 18;
                $this->merge(['est_mineur' => $estMineur ? 1 : 0]);
            } catch (\Exception $e) {
                // Date invalide : laissée à la validation du champ date_naissance.
            }
        }
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

            'est_mineur' => ['nullable', 'boolean'],

            // Rôles attribués (cases à cocher)
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],

            // Certificat médical (PDF facultatif ; date requise si fichier fourni)
            'certificat_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'certificat_delivre_le' => ['nullable', 'required_with:certificat_pdf', 'date', 'before_or_equal:today'],

            // Représentant légal (obligatoire pour un mineur)
            'representant_civilite' => ['nullable', 'string', 'in:M.,Mme,Autre'],
            'representant_prenom' => ['nullable', 'required_if:est_mineur,1', 'string', 'max:80'],
            'representant_nom' => ['nullable', 'required_if:est_mineur,1', 'string', 'max:80'],
            'representant_lien_parente' => ['nullable', 'required_if:est_mineur,1', 'string', 'max:50'],
            'representant_email' => ['nullable', 'email', 'max:191'],
            'representant_telephone' => ['nullable', 'string', 'max:20'],
            'representant_mobile' => ['nullable', 'string', 'max:20'],

            // Consentements RGPD
            'consentement_rgpd' => ['accepted'],
            'autorisation_parentale' => ['accepted_if:est_mineur,1'],
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
            'roles.*.exists' => 'Un des rôles sélectionnés est invalide.',
            'certificat_pdf.mimes' => 'Le certificat médical doit être un fichier PDF.',
            'certificat_pdf.max' => 'Le certificat médical ne peut pas dépasser 5 Mo.',
            'certificat_delivre_le.required_with' => 'La date de délivrance du certificat est obligatoire.',
            'representant_prenom.required_if' => 'Le prénom du représentant légal est obligatoire pour un mineur.',
            'representant_nom.required_if' => 'Le nom du représentant légal est obligatoire pour un mineur.',
            'representant_lien_parente.required_if' => 'Le lien de parenté est obligatoire pour un mineur.',
            'consentement_rgpd.accepted' => 'Le consentement au traitement des données (RGPD) est obligatoire.',
            'autorisation_parentale.accepted_if' => 'L\'autorisation parentale est obligatoire pour un mineur.',
        ];
    }
}
