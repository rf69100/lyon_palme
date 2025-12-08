@extends('layouts.auth')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="/LyonPalme.png" alt="Lyon Palme" class="h-16 mx-auto mb-4">
            <p class="text-slate-600">Réinitialiser votre mot de passe</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">Mot de passe oublié ?</h2>
            <p class="text-slate-600 text-sm mb-6 text-center">
                Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
            </p>

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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

                <!-- Bouton submit -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-cyan-500 text-white py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-cyan-600 transition duration-200 mt-6"
                >
                    Envoyer le lien
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-slate-600">
            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection
