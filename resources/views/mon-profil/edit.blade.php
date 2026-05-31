@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                &larr; Retour au tableau de bord
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Mon profil</h1>
            <p class="text-slate-600">Mettez à jour vos coordonnées et vos préférences de visibilité.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg">{{ session('error') }}</div>
        @endif

        @unless($adherent)
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <p class="text-slate-700">Aucune fiche adhérent n'est associée à votre compte. Contactez le secrétariat.</p>
            </div>
        @else
            <form method="POST" action="{{ route('mon-profil.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Identité</h2>
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-semibold text-slate-600">Nom</dt>
                            <dd class="text-lg text-slate-900">{{ $adherent->nom_complet }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-slate-600">Date de naissance</dt>
                            <dd class="text-lg text-slate-900">{{ \Carbon\Carbon::parse($adherent->date_naissance)->format('d/m/Y') }}</dd>
                        </div>
                    </dl>
                    <p class="mt-4 text-sm text-slate-500">Pour corriger votre nom ou votre date de naissance, contactez le secrétariat.</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Coordonnées</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $adherent->email) }}" maxlength="255"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="telephone" class="block text-sm font-semibold text-slate-700 mb-2">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $adherent->telephone) }}" maxlength="20"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="mobile" class="block text-sm font-semibold text-slate-700 mb-2">Mobile</label>
                            <input type="tel" id="mobile" name="mobile" value="{{ old('mobile', $adherent->mobile) }}" maxlength="20"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                        <div>
                            <label for="numero_rue" class="block text-sm font-semibold text-slate-700 mb-2">N°</label>
                            <input type="text" id="numero_rue" name="numero_rue" value="{{ old('numero_rue', $adherent->numero_rue) }}" maxlength="10"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div class="md:col-span-3">
                            <label for="rue" class="block text-sm font-semibold text-slate-700 mb-2">Rue</label>
                            <input type="text" id="rue" name="rue" value="{{ old('rue', $adherent->rue) }}" maxlength="255"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label for="code_postal" class="block text-sm font-semibold text-slate-700 mb-2">Code postal</label>
                            <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal', $adherent->code_postal) }}" maxlength="10"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="ville" class="block text-sm font-semibold text-slate-700 mb-2">Ville</label>
                            <input type="text" id="ville" name="ville" value="{{ old('ville', $adherent->ville) }}" maxlength="100"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Visibilité (RGPD)</h2>
                    <p class="text-slate-600 mb-6">Choisissez si vous souhaitez apparaître auprès des autres nageurs.</p>

                    <label class="flex items-start gap-3 mb-4">
                        <input type="checkbox" name="afficher_trombinoscope" value="1" {{ old('afficher_trombinoscope', $adherent->afficher_trombinoscope) ? 'checked' : '' }}
                            class="mt-1 w-5 h-5 rounded text-purple-600 focus:ring-purple-500">
                        <span class="text-slate-700">Apparaître dans le <strong>trombinoscope</strong> des nageurs.</span>
                    </label>
                    <label class="flex items-start gap-3">
                        <input type="checkbox" name="afficher_annuaire" value="1" {{ old('afficher_annuaire', $adherent->afficher_annuaire) ? 'checked' : '' }}
                            class="mt-1 w-5 h-5 rounded text-purple-600 focus:ring-purple-500">
                        <span class="text-slate-700">Apparaître dans l'<strong>annuaire</strong> (mes coordonnées visibles par les autres nageurs).</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                    Enregistrer
                </button>
            </form>
        @endunless
    </div>
</div>
@endsection
