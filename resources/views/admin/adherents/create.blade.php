@extends('layouts.app')

@section('title', 'Nouvel Adhérent - Lyon Palme')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.adherents.index') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour à la liste
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Nouvel Adhérent</h1>
            <p class="text-slate-600">Ajouter un nouveau membre au club</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.adherents.store') }}" class="space-y-6">
            @csrf

            <!-- Informations personnelles -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Informations personnelles</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Civilité -->
                    <div>
                        <label for="civilite" class="block text-sm font-semibold text-slate-700 mb-2">
                            Civilité <span class="text-red-500">*</span>
                        </label>
                        <select id="civilite" name="civilite" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('civilite') border-red-500 @enderror">
                            <option value="">Sélectionner</option>
                            <option value="M." {{ old('civilite') === 'M.' ? 'selected' : '' }}>M.</option>
                            <option value="Mme" {{ old('civilite') === 'Mme' ? 'selected' : '' }}>Mme</option>
                            <option value="Autre" {{ old('civilite') === 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('civilite')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label for="prenom" class="block text-sm font-semibold text-slate-700 mb-2">
                            Prénom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required maxlength="100" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('prenom') border-red-500 @enderror">
                        @error('prenom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block text-sm font-semibold text-slate-700 mb-2">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required maxlength="100" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nom') border-red-500 @enderror">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Date de naissance -->
                    <div>
                        <label for="date_naissance" class="block text-sm font-semibold text-slate-700 mb-2">
                            Date de naissance <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}" required max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('date_naissance') border-red-500 @enderror">
                        @error('date_naissance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div>
                        <label for="statut" class="block text-sm font-semibold text-slate-700 mb-2">
                            Statut <span class="text-red-500">*</span>
                        </label>
                        <select id="statut" name="statut" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('statut') border-red-500 @enderror">
                            <option value="actif" {{ old('statut', 'actif') === 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="inactif" {{ old('statut') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                            <option value="radie" {{ old('statut') === 'radie' ? 'selected' : '' }}>Radié</option>
                        </select>
                        @error('statut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Coordonnées -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Coordonnées</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                            Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="255" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="block text-sm font-semibold text-slate-700 mb-2">
                            Téléphone
                        </label>
                        <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" maxlength="20" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('telephone') border-red-500 @enderror">
                        @error('telephone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="mobile" class="block text-sm font-semibold text-slate-700 mb-2">
                        Mobile
                    </label>
                    <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" maxlength="20" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('mobile') border-red-500 @enderror">
                    @error('mobile')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Adresse -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Adresse</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="numero_rue" class="block text-sm font-semibold text-slate-700 mb-2">
                            Numéro
                        </label>
                        <input type="text" id="numero_rue" name="numero_rue" value="{{ old('numero_rue') }}" maxlength="10" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div class="md:col-span-3">
                        <label for="rue" class="block text-sm font-semibold text-slate-700 mb-2">
                            Rue
                        </label>
                        <input type="text" id="rue" name="rue" value="{{ old('rue') }}" maxlength="255" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="mt-6">
                    <label for="complement_adresse" class="block text-sm font-semibold text-slate-700 mb-2">
                        Complément d'adresse
                    </label>
                    <input type="text" id="complement_adresse" name="complement_adresse" value="{{ old('complement_adresse') }}" maxlength="255" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="code_postal" class="block text-sm font-semibold text-slate-700 mb-2">
                            Code postal
                        </label>
                        <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal') }}" maxlength="10" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="ville" class="block text-sm font-semibold text-slate-700 mb-2">
                            Ville
                        </label>
                        <input type="text" id="ville" name="ville" value="{{ old('ville') }}" maxlength="100" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                    Créer l'adhérent
                </button>
                <a href="{{ route('admin.adherents.index') }}" class="flex-1 bg-slate-200 text-slate-700 px-6 py-3 rounded-lg font-semibold hover:bg-slate-300 transition text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
