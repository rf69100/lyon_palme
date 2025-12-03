@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center px-4 py-12 relative">
    <!-- Bouton Retour à l'accueil -->
    <a href="/" class="absolute bottom-8 right-8 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 font-medium transition duration-200 text-sm">
        ← Accueil
    </a>

    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">🏊 Lyon Palme</h1>
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
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 placeholder-slate-400"
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
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 placeholder-slate-400"
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
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 placeholder-slate-400"
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
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 placeholder-slate-400"
                        placeholder="Confirmez votre mot de passe"
                    />
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton submit -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 mt-6"
                >
                    S'inscrire
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-slate-600">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Se connecter</a>
        </div>
    </div>
</div>
@endsection
