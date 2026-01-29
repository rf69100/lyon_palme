@extends('layouts.app')

@section('title', 'Ajouter un paiement')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.cotisations.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux cotisations
            </a>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-cyan-500 bg-clip-text text-transparent">
                Ajouter un paiement
            </h1>
            <p class="mt-2 text-slate-600">
                {{ $adhesion->adherent?->prenom }} {{ $adhesion->adherent?->nom }}
            </p>
        </div>

        <!-- Récapitulatif adhésion -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Récapitulatif de l'adhésion</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-slate-500">Saison</p>
                    <p class="font-medium text-slate-900">{{ $adhesion->saison?->nom ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Type</p>
                    <p class="font-medium text-slate-900">{{ $adhesion->typeAdhesion?->nom ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Montant total</p>
                    <p class="font-medium text-slate-900">{{ number_format($adhesion->montant_attendu, 2, ',', ' ') }}€</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Déjà payé</p>
                    <p class="font-medium text-slate-900">{{ number_format($adhesion->montant_paye, 2, ',', ' ') }}€</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-200">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-semibold text-slate-800">Solde restant</span>
                    <span class="text-2xl font-bold text-red-600">{{ number_format($adhesion->solde, 2, ',', ' ') }}€</span>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-6">Informations du paiement</h2>

            <form method="POST" action="{{ route('admin.paiements.store', $adhesion) }}">
                @csrf

                <!-- Montant -->
                <div class="mb-6">
                    <label for="montant" class="block text-sm font-medium text-slate-700 mb-1">
                        Montant <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number"
                               name="montant"
                               id="montant"
                               step="0.01"
                               min="0.01"
                               max="{{ $adhesion->solde }}"
                               value="{{ old('montant', $adhesion->solde) }}"
                               class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 pr-12 @error('montant') border-red-500 @enderror"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-slate-500">€</span>
                        </div>
                    </div>
                    @error('montant')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-slate-500">Maximum : {{ number_format($adhesion->solde, 2, ',', ' ') }}€</p>
                </div>

                <!-- Mode de paiement -->
                <div class="mb-6">
                    <label for="moyen_paiement" class="block text-sm font-medium text-slate-700 mb-1">
                        Mode de paiement <span class="text-red-500">*</span>
                    </label>
                    <select name="moyen_paiement"
                            id="moyen_paiement"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('moyen_paiement') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner un mode de paiement</option>
                        @foreach($modesPaiement as $code => $libelle)
                            <option value="{{ $code }}" {{ old('moyen_paiement') === $code ? 'selected' : '' }}>
                                {{ $libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('moyen_paiement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de paiement -->
                <div class="mb-6">
                    <label for="date_paiement" class="block text-sm font-medium text-slate-700 mb-1">
                        Date de paiement <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="date_paiement"
                           id="date_paiement"
                           max="{{ date('Y-m-d') }}"
                           value="{{ old('date_paiement', date('Y-m-d')) }}"
                           class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('date_paiement') border-red-500 @enderror"
                           required>
                    @error('date_paiement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Numéro de reçu -->
                <div class="mb-6">
                    <label for="numero_recu" class="block text-sm font-medium text-slate-700 mb-1">
                        Numéro de reçu <span class="text-slate-400">(optionnel)</span>
                    </label>
                    <input type="text"
                           name="numero_recu"
                           id="numero_recu"
                           maxlength="50"
                           value="{{ old('numero_recu') }}"
                           placeholder="Ex: REC-2025-001"
                           class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('numero_recu') border-red-500 @enderror">
                    @error('numero_recu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remarques -->
                <div class="mb-6">
                    <label for="remarques" class="block text-sm font-medium text-slate-700 mb-1">
                        Remarques <span class="text-slate-400">(optionnel)</span>
                    </label>
                    <textarea name="remarques"
                              id="remarques"
                              rows="3"
                              maxlength="500"
                              placeholder="Notes ou commentaires..."
                              class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('remarques') border-red-500 @enderror">{{ old('remarques') }}</textarea>
                    @error('remarques')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-slate-500">Maximum 500 caractères</p>
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.cotisations.index') }}"
                       class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-medium transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium transition duration-200 shadow-md">
                        Enregistrer le paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
