@extends('layouts.app')

@section('title', 'Gestion des Adhérents - Lyon Palme')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour au dashboard
                </a>
                <h1 class="text-4xl font-bold text-slate-900 mb-2">Gestion des Adhérents</h1>
                <p class="text-slate-600">Liste complète des membres du club</p>
            </div>
            <a href="{{ route('admin.adherents.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvel adhérent
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-slate-200">
            <form method="GET" action="{{ route('admin.adherents.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, prénom..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Statut</label>
                    <select name="statut" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Tous</option>
                        <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>Actifs</option>
                        <option value="archive" {{ request('statut') === 'archive' ? 'selected' : '' }}>Archivés</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Type</label>
                    <select name="type" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Tous</option>
                        <option value="majeur" {{ request('type') === 'majeur' ? 'selected' : '' }}>Majeurs</option>
                        <option value="mineur" {{ request('type') === 'mineur' ? 'selected' : '' }}>Mineurs</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                        Filtrer
                    </button>
                    <a href="{{ route('admin.adherents.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-lg font-semibold hover:bg-slate-300 transition">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Nom complet</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Téléphone</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Statut</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-slate-900">Type</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-slate-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($adherents as $adherent)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $adherent->nom_complet }}</div>
                                    <div class="text-sm text-slate-500">{{ $adherent->civilite }}</div>
                                </td>
                                <td class="px-6 py-4 text-slate-700">{{ $adherent->email ?: '-' }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $adherent->mobile ?: $adherent->telephone ?: '-' }}</td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4">
                                    @if($adherent->est_mineur)
                                        <span class="text-sm text-blue-600 font-semibold">Mineur</span>
                                    @else
                                        <span class="text-sm text-slate-600">Majeur</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.adherents.show', $adherent) }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                                            Voir
                                        </a>
                                        <a href="{{ route('admin.adherents.edit', $adherent) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                                            Modifier
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    Aucun adhérent trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($adherents->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $adherents->links() }}
                </div>
            @endif
        </div>

        <!-- Stats -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                <div class="text-slate-600 text-sm font-medium mb-1">Total adhérents</div>
                <div class="text-3xl font-bold text-slate-900">{{ $adherents->total() }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                <div class="text-slate-600 text-sm font-medium mb-1">Page actuelle</div>
                <div class="text-3xl font-bold text-slate-900">{{ $adherents->currentPage() }} / {{ $adherents->lastPage() }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                <div class="text-slate-600 text-sm font-medium mb-1">Par page</div>
                <div class="text-3xl font-bold text-slate-900">{{ $adherents->perPage() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
