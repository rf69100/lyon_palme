@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center px-4 py-12 relative">
    <!-- Bouton Retour à l'accueil -->
    <a href="{{ url('/') }}" class="absolute bottom-8 right-8 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 font-medium transition duration-200 text-sm">
        ← Accueil
    </a>

    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="/LyonPalme.png" alt="Lyon Palme" class="h-16 mx-auto mb-4">
            <p class="text-slate-600">Créer votre compte</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">S'inscrire</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-slate-700 mb-2">Nom complet</label>
                    <input
                        id="nom"
                        type="text"
                        name="nom"
                        value="{{ old('nom') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-slate-900 placeholder-slate-400"
                        placeholder="Votre nom complet"
                    />
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-slate-900 placeholder-slate-400"
                        placeholder="votre@email.com"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Mot de passe</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-slate-900 placeholder-slate-400"
                        placeholder="Au moins 8 caractères"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirmer le mot de passe</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-slate-900 placeholder-slate-400"
                        placeholder="Confirmez votre mot de passe"
                    />
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Consentements RGPD -->
                <div class="space-y-3 pt-4 border-t border-slate-200">
                    <!-- Politique de confidentialité -->
                    <div class="flex items-start">
                        <input
                            id="accept_privacy"
                            type="checkbox"
                            name="accept_privacy"
                            required
                            class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-slate-300 rounded"
                        />
                        <label for="accept_privacy" class="ml-3 text-sm text-slate-700">
                            J'ai lu et j'accepte la
                            <a href="{{ route('confidentialite') }}" target="_blank" class="text-purple-600 hover:text-purple-700 underline">politique de confidentialité</a>
                            <span class="text-red-600">*</span>
                        </label>
                    </div>
                    @error('accept_privacy')
                        <p class="ml-7 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Conditions d'utilisation -->
                    <div class="flex items-start">
                        <input
                            id="accept_terms"
                            type="checkbox"
                            name="accept_terms"
                            required
                            class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-slate-300 rounded"
                        />
                        <label for="accept_terms" class="ml-3 text-sm text-slate-700">
                            J'accepte les
                            <a href="{{ route('conditions') }}" target="_blank" class="text-purple-600 hover:text-purple-700 underline">conditions générales d'utilisation</a>
                            <span class="text-red-600">*</span>
                        </label>
                    </div>
                    @error('accept_terms')
                        <p class="ml-7 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Traitement des données -->
                    <div class="flex items-start">
                        <input
                            id="accept_data_processing"
                            type="checkbox"
                            name="accept_data_processing"
                            required
                            class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-slate-300 rounded"
                        />
                        <label for="accept_data_processing" class="ml-3 text-sm text-slate-700">
                            J'autorise le traitement de mes données personnelles conformément au
                            <a href="{{ route('rgpd') }}" target="_blank" class="text-purple-600 hover:text-purple-700 underline">RGPD</a>
                            <span class="text-red-600">*</span>
                        </label>
                    </div>
                    @error('accept_data_processing')
                        <p class="ml-7 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Communication (optionnel) -->
                    <div class="flex items-start">
                        <input
                            id="accept_communications"
                            type="checkbox"
                            name="accept_communications"
                            class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-slate-300 rounded"
                        />
                        <label for="accept_communications" class="ml-3 text-sm text-slate-700">
                            J'accepte de recevoir des communications du club Lyon Palme (informations, événements, actualités)
                            <span class="text-slate-500 text-xs">(optionnel)</span>
                        </label>
                    </div>

                    <p class="text-xs text-slate-500 mt-4">
                        <span class="text-red-600">*</span> Champs obligatoires.
                        Vous pouvez retirer votre consentement à tout moment depuis les paramètres de votre compte.
                    </p>
                </div>

                <!-- Bouton submit -->
                <button
                    type="submit"
                    class="w-full bg-purple-600 text-white py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-200 mt-6"
                >
                    S'inscrire
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-slate-600">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">Se connecter</a>
        </div>
    </div>
</div>
@endsection
