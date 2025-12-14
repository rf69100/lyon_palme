@extends('layouts.auth')

@section('title', 'Connexion')

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
            <p class="text-slate-600">Connexion à votre compte</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">Se connecter</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800">
                    <p class="font-medium">Erreur d'authentification</p>
                    <p>Vérifiez vos identifiants et réessayez.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

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
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="rounded border-slate-300 text-purple-600 focus:ring-purple-500" />
                    <label for="remember" class="ml-2 text-sm text-slate-700">Se souvenir de moi</label>
                </div>

                <!-- Bouton submit -->
                <button
                    type="submit"
                    class="w-full bg-purple-600 text-white py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-200 mt-6"
                >
                    Se connecter
                </button>
            </form>

            <!-- Mot de passe oublié -->
            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                    Mot de passe oublié ?
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-slate-600">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-700 font-semibold">S'inscrire</a>
        </div>
    </div>
</div>
@endsection
