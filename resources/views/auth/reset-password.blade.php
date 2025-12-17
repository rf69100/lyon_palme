@extends('layouts.auth')

@section('title', 'Réinitialiser le mot de passe')

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
            <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">Nouveau mot de passe</h2>

            <form method="POST" action="{{ url('/reset-password') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ $request->email }}"
                        required
                        readonly
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-slate-900 bg-slate-50"
                    />
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Nouveau mot de passe</label>
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

                <!-- Bouton submit -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-cyan-500 text-white py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-cyan-600 transition duration-200 mt-6"
                >
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
