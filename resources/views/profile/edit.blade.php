@extends('layouts.public')

@section('title', 'Modifier mon profil - Lyon Palme')

@section('content')

<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-6">Modifier mon profil</h1>
            <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                Mettez à jour vos informations personnelles
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
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nom" class="block text-slate-700 font-medium mb-2">Nom</label>
                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        value="{{ old('nom', $user->nom) }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 @error('nom') border-red-500 @enderror"
                        required
                    >
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-slate-700 font-medium mb-2">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 @error('email') border-red-500 @enderror"
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium">
                        Enregistrer les modifications
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
