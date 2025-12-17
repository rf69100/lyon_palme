@extends('layouts.app')

@section('title', $adherent->nom_complet . ' - Lyon Palme')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <a href="{{ route('admin.adherents.index') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour à la liste
                </a>
                <h1 class="text-4xl font-bold text-slate-900 mb-2">{{ $adherent->nom_complet }}</h1>
                <div class="flex items-center gap-3">
                    @if($adherent->statut === 'actif')
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Actif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ ucfirst($adherent->statut) }}
                        </span>
                    @endif

                    @if($adherent->est_mineur)
                        <span class="text-sm text-blue-600 font-semibold">Mineur</span>
                    @endif
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.adherents.edit', $adherent) }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Modifier
                </a>
                @if($adherent->statut === 'actif')
                    <form method="POST" action="{{ route('admin.adherents.destroy', $adherent) }}" onsubmit="return confirm('Voulez-vous vraiment archiver cet adhérent ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                            Archiver
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.adherents.restore', $adherent) }}">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                            Réactiver
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations personnelles -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Informations personnelles</h2>
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-semibold text-slate-600">Civilité</dt>
                            <dd class="text-lg text-slate-900">{{ $adherent->civilite }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-slate-600">Date de naissance</dt>
                            <dd class="text-lg text-slate-900">{{ \Carbon\Carbon::parse($adherent->date_naissance)->format('d/m/Y') }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="text-sm font-semibold text-slate-600">Email</dt>
                            <dd class="text-lg text-slate-900">{{ $adherent->email ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-slate-600">Téléphone</dt>
                            <dd class="text-lg text-slate-900">{{ $adherent->telephone ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-slate-600">Mobile</dt>
                            <dd class="text-lg text-slate-900">{{ $adherent->mobile ?: '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Adresse -->
                @if($adherent->adresse_complete)
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Adresse</h2>
                        <p class="text-lg text-slate-700">{{ $adherent->adresse_complete }}</p>
                    </div>
                @endif

                <!-- Adhésions -->
                @if($adherent->adhesions->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Adhésions</h2>
                        <div class="space-y-3">
                            @foreach($adherent->adhesions->take(5) as $adhesion)
                                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-lg">
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $adhesion->saison->nom }}</div>
                                        <div class="text-sm text-slate-600">{{ $adhesion->typeAdhesion->nom }}</div>
                                    </div>
                                    <span class="text-sm font-semibold {{ $adhesion->statut === 'valide' ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ ucfirst($adhesion->statut) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Statistiques</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Adhésions</span>
                            <span class="font-bold text-slate-900">{{ $adherent->adhesions->count() }}</span>
                        </div>
                        @if($adherent->roles->count() > 0)
                            <div class="flex justify-between">
                                <span class="text-slate-600">Rôles</span>
                                <span class="font-bold text-slate-900">{{ $adherent->roles->count() }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Rôles -->
                @if($adherent->roles->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Rôles</h3>
                        <div class="space-y-2">
                            @foreach($adherent->roles as $role)
                                <div class="px-3 py-2 bg-purple-50 text-purple-700 rounded-lg text-sm font-semibold">
                                    {{ $role->nom_affichage }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Représentants légaux (si mineur) -->
                @if($adherent->est_mineur && $adherent->representantsLegaux->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Représentants légaux</h3>
                        <div class="space-y-3">
                            @foreach($adherent->representantsLegaux as $representant)
                                <div class="p-3 bg-blue-50 rounded-lg">
                                    <div class="font-semibold text-slate-900">{{ $representant->nom_complet }}</div>
                                    @if($representant->est_principal)
                                        <div class="text-xs text-blue-600 font-semibold">Principal</div>
                                    @endif
                                    @if($representant->telephone)
                                        <div class="text-sm text-slate-600">{{ $representant->telephone }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
