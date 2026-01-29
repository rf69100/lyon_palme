@extends('layouts.app')

@section('title', 'Cotisations et Paiements')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-cyan-500 bg-clip-text text-transparent">
                Cotisations et Paiements
            </h1>
            <p class="mt-2 text-slate-600">
                Gestion des cotisations et suivi des paiements des adhérents
            </p>
        </div>

        <!-- Messages flash -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 sticky top-20 z-40">
            <form method="GET" action="{{ route('admin.cotisations.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Filtre Saison -->
                <div class="flex-1 min-w-[180px]">
                    <label for="saison_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Saison
                    </label>
                    <select name="saison_id" id="saison_id"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="toutes" {{ $filtreSaison === 'toutes' ? 'selected' : '' }}>Toutes les saisons</option>
                        <option value="courante" {{ $filtreSaison === 'courante' ? 'selected' : '' }}>Saison courante</option>
                        @foreach($saisons as $saison)
                            <option value="{{ $saison->id }}" {{ $filtreSaison == $saison->id ? 'selected' : '' }}>
                                {{ $saison->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre Statut Paiement -->
                <div class="flex-1 min-w-[180px]">
                    <label for="statut_paiement" class="block text-sm font-medium text-slate-700 mb-1">
                        Statut paiement
                    </label>
                    <select name="statut_paiement" id="statut_paiement"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="tous" {{ $filtreStatut === 'tous' ? 'selected' : '' }}>Tous les statuts</option>
                        <option value="a_jour" {{ $filtreStatut === 'a_jour' ? 'selected' : '' }}>À jour</option>
                        <option value="partiels" {{ $filtreStatut === 'partiels' ? 'selected' : '' }}>Partiels</option>
                        <option value="impayes" {{ $filtreStatut === 'impayes' ? 'selected' : '' }}>Impayés</option>
                    </select>
                </div>

                <!-- Filtre Type Adhésion -->
                <div class="flex-1 min-w-[180px]">
                    <label for="type_adhesion_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Type d'adhésion
                    </label>
                    <select name="type_adhesion_id" id="type_adhesion_id"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="tous" {{ $filtreType === 'tous' ? 'selected' : '' }}>Tous les types</option>
                        @foreach($typesAdhesion as $type)
                            <option value="{{ $type->id }}" {{ $filtreType == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Boutons -->
                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium transition duration-200 shadow-md">
                        Filtrer
                    </button>
                    <a href="{{ route('admin.cotisations.index') }}"
                       class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-medium transition duration-200">
                        Réinitialiser
                    </a>
                    <a href="{{ route('admin.cotisations.export', ['saison_id' => $filtreSaison, 'statut_paiement' => $filtreStatut, 'type_adhesion_id' => $filtreType]) }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition duration-200 shadow-md flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exporter Excel
                    </a>
                </div>
            </form>
        </div>

        <!-- Tableau des cotisations -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @if($adhesions->isEmpty())
                <div class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-slate-500 text-lg">Aucune cotisation trouvée</p>
                    <p class="text-slate-400 text-sm mt-1">Modifiez les filtres pour voir d'autres résultats</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-gradient-to-r from-purple-600 to-cyan-500">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Photo
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Adhérent
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Saison
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">
                                    Payé
                                </th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">
                                    Solde
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Dernier paiement
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($adhesions as $adhesion)
                                @php
                                    $dernierPaiement = $adhesion->paiements->sortByDesc('paye_le')->first();
                                    $statutPaiement = $adhesion->statut_paiement;
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <!-- Photo -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-400 to-cyan-400 flex items-center justify-center text-white font-semibold text-sm">
                                            @if($adhesion->adherent)
                                                {{ strtoupper(substr($adhesion->adherent->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($adhesion->adherent->nom ?? '', 0, 1)) }}
                                            @else
                                                NA
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Adhérent -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $adhesion->adherent?->prenom ?? 'N/A' }} {{ $adhesion->adherent?->nom ?? '' }}
                                        </div>
                                        <div class="text-sm text-slate-500">
                                            {{ $adhesion->adherent?->email ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <!-- Saison -->
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-600">
                                        {{ $adhesion->saison?->nom ?? 'N/A' }}
                                    </td>

                                    <!-- Type -->
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-600">
                                        {{ $adhesion->typeAdhesion?->nom ?? 'N/A' }}
                                    </td>

                                    <!-- Montant total -->
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 text-right font-medium">
                                        {{ number_format($adhesion->montant_attendu, 2, ',', ' ') }}€
                                    </td>

                                    <!-- Montant payé -->
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-600 text-right">
                                        {{ number_format($adhesion->montant_paye, 2, ',', ' ') }}€
                                    </td>

                                    <!-- Solde -->
                                    <td class="px-4 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-medium {{ $adhesion->solde <= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($adhesion->solde, 2, ',', ' ') }}€
                                        </span>
                                    </td>

                                    <!-- Dernier paiement -->
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-600">
                                        @if($dernierPaiement)
                                            <div>{{ $dernierPaiement->paye_le?->format('d/m/Y') }}</div>
                                            <div class="text-xs text-slate-400">{{ $dernierPaiement->mode_paiement_libelle ?? $dernierPaiement->moyen_paiement }}</div>
                                        @else
                                            <span class="text-slate-400">Aucun</span>
                                        @endif
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @switch($statutPaiement)
                                            @case('a_jour')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3"/>
                                                    </svg>
                                                    À jour
                                                </span>
                                                @break
                                            @case('partiel')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3"/>
                                                    </svg>
                                                    Partiel
                                                </span>
                                                @break
                                            @case('impaye')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3"/>
                                                    </svg>
                                                    Impayé
                                                </span>
                                                @break
                                        @endswitch
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            @if($adhesion->solde > 0)
                                                <a href="{{ route('admin.paiements.create', $adhesion) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-150 font-medium"
                                                   title="Ajouter un paiement">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    Paiement
                                                </a>
                                            @endif
                                            <a href="#"
                                               class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-150 font-medium"
                                               title="Voir l'adhérent">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Voir
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                    {{ $adhesions->links() }}
                </div>
            @endif
        </div>

        <!-- Statistiques rapides -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
            @php
                $totalAdhesions = \App\Models\Adhesion::count();
                $aJour = \App\Models\Adhesion::whereRaw('solde <= 0')->count();
                $partiels = \App\Models\Adhesion::where('montant_paye', '>', 0)->whereRaw('solde > 0')->count();
                $impayes = \App\Models\Adhesion::where('montant_paye', '=', 0)->whereRaw('solde > 0')->count();
            @endphp

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-slate-100 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalAdhesions }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">À jour</p>
                        <p class="text-2xl font-bold text-green-600">{{ $aJour }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Partiels</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $partiels }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Impayés</p>
                        <p class="text-2xl font-bold text-red-600">{{ $impayes }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
