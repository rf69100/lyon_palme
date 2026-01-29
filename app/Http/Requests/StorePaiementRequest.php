<?php

namespace App\Http\Requests;

use App\Models\Paiement;
use Illuminate\Foundation\Http\FormRequest;

class StorePaiementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $adhesion = $this->route('adhesion');
        $soldeRestant = (float) $adhesion->solde;

        return [
            'montant' => [
                'required',
                'numeric',
                'gt:0',
                'max:'.$soldeRestant,
            ],
            'moyen_paiement' => [
                'required',
                'string',
                'in:'.implode(',', array_keys(Paiement::MODES_PAIEMENT)),
            ],
            'date_paiement' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'numero_recu' => [
                'nullable',
                'string',
                'max:50',
            ],
            'remarques' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $adhesion = $this->route('adhesion');
        $soldeRestant = number_format((float) $adhesion->solde, 2, ',', ' ');

        return [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.gt' => 'Le montant doit être supérieur à 0.',
            'montant.max' => "Le montant ne peut pas dépasser le solde restant ({$soldeRestant}€).",
            'moyen_paiement.required' => 'Le mode de paiement est obligatoire.',
            'moyen_paiement.in' => 'Le mode de paiement sélectionné est invalide.',
            'date_paiement.required' => 'La date de paiement est obligatoire.',
            'date_paiement.date' => 'La date de paiement doit être une date valide.',
            'date_paiement.before_or_equal' => 'La date de paiement ne peut pas être dans le futur.',
            'numero_recu.max' => 'Le numéro de reçu ne peut pas dépasser 50 caractères.',
            'remarques.max' => 'Les remarques ne peuvent pas dépasser 500 caractères.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'montant' => 'montant',
            'moyen_paiement' => 'mode de paiement',
            'date_paiement' => 'date de paiement',
            'numero_recu' => 'numéro de reçu',
            'remarques' => 'remarques',
        ];
    }
}
