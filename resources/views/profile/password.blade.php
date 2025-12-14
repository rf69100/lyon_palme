@extends('layouts.public')

@section('title', 'Changer mon mot de passe - Lyon Palme')

@section('content')

<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-6">Changer mon mot de passe</h1>
            <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                Sécurisez votre compte avec un nouveau mot de passe
            </p>
        </div>
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <div class="max-w-2xl mx-auto">
        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 mb-6">
                <p class="text-green-600 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
            <form action="{{ route('password.change') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="current_password" class="block text-slate-700 font-medium mb-2">Mot de passe actuel</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 @error('current_password') border-red-500 @enderror"
                        required
                    >
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-slate-700 font-medium mb-2">Nouveau mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 @error('password') border-red-500 @enderror"
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-slate-500 text-sm mt-1">Le mot de passe doit contenir au moins 8 caractères.</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-slate-700 font-medium mb-2">Confirmer le nouveau mot de passe</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        required
                    >
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium">
                        Modifier le mot de passe
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex-1 px-6 py-3 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-medium text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
