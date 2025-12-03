@extends('layouts.auth')

@section('title', 'Confirmer le mot de passe')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">🏊 Lyon Palme</h1>
            <p class="text-slate-600">Confirmation de sécurité</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">Confirmez votre mot de passe</h2>
            <p class="text-slate-600 text-sm mb-6 text-center">
                Cette action requiert une confirmation de sécurité. Veuillez entrer votre mot de passe pour continuer.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Mot de passe</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autofocus
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 placeholder-slate-400"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton submit -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 mt-6"
                >
                    Confirmer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
