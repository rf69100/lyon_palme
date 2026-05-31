@extends('layouts.app')

@section('title', 'Certificats Médicaux')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-cyan-500 bg-clip-text text-transparent">
                Certificats Médicaux
            </h1>
            <p class="mt-2 text-slate-600">
                Suivi des certificats médicaux des adhérents
            </p>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 sticky top-20 z-40">
            <form method="GET" action="{{ route('admin.certificats.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Filtre Statut -->
                <div class="flex-1 min-w-[200px]">
                    <label for="statut" class="block text-sm font-medium text-slate-700 mb-1">
                        Statut du certificat
                    </label>
                    <select name="statut" id="statut"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="tous" {{ $filtreStatut === 'tous' ? 'selected' : '' }}>Tous les statuts</option>
                        <option value="valides" {{ $filtreStatut === 'valides' ? 'selected' : '' }}>Valides</option>
                        <option value="expire_bientot" {{ $filtreStatut === 'expire_bientot' ? 'selected' : '' }}>Expire bientôt (&lt; 30j)</option>
                        <option value="expires" {{ $filtreStatut === 'expires' ? 'selected' : '' }}>Expirés</option>
                    </select>
                </div>

                <!-- Filtre Questionnaire Santé -->
                <div class="flex-1 min-w-[200px]">
                    <label for="questionnaire_sante" class="block text-sm font-medium text-slate-700 mb-1">
                        Questionnaire santé
                    </label>
                    <select name="questionnaire_sante" id="questionnaire_sante"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="tous" {{ $filtreQuestionnaire === 'tous' ? 'selected' : '' }}>Tous</option>
                        <option value="requis" {{ $filtreQuestionnaire === 'requis' ? 'selected' : '' }}>Requis</option>
                        <option value="non_requis" {{ $filtreQuestionnaire === 'non_requis' ? 'selected' : '' }}>Non requis</option>
                    </select>
                </div>

                <!-- Boutons -->
                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium transition duration-200 shadow-md">
                        Filtrer
                    </button>
                    <a href="{{ route('admin.certificats.index') }}"
                       class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-medium transition duration-200">
                        Réinitialiser
                    </a>
                    <a href="{{ route('admin.certificats.export', ['statut' => $filtreStatut, 'questionnaire_sante' => $filtreQuestionnaire]) }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition duration-200 shadow-md flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exporter Excel
                    </a>
                </div>
            </form>
        </div>

        <!-- Tableau des certificats -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @if($certificats->isEmpty())
                <div class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-slate-500 text-lg">Aucun certificat médical trouvé</p>
                    <p class="text-slate-400 text-sm mt-1">Modifiez les filtres pour voir d'autres résultats</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-gradient-to-r from-purple-600 to-cyan-500">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Photo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Adhérent
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Date d'émission
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Date d'expiration
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Jours restants
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Questionnaire
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($certificats as $certificat)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <!-- Photo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-400 to-cyan-400 flex items-center justify-center text-white font-semibold text-sm">
                                            @if($certificat->adherent)
                                                {{ strtoupper(substr($certificat->adherent->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($certificat->adherent->nom ?? '', 0, 1)) }}
                                            @else
                                                NA
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Adhérent -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $certificat->adherent?->prenom ?? 'N/A' }} {{ $certificat->adherent?->nom ?? '' }}
                                        </div>
                                        <div class="text-sm text-slate-500">
                                            {{ $certificat->adherent?->email ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <!-- Date d'émission -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                        {{ $certificat->delivre_le?->format('d/m/Y') ?? 'N/A' }}
                                    </td>

                                    <!-- Date d'expiration -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                        {{ $certificat->expire_le?->format('d/m/Y') ?? 'N/A' }}
                                    </td>

                                    <!-- Jours restants -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium {{ $certificat->jours_restants <= 0 ? 'text-red-600' : ($certificat->jours_restants <= 30 ? 'text-orange-600' : 'text-green-600') }}">
                                            @if($certificat->jours_restants <= 0)
                                                {{ abs($certificat->jours_restants) }} jour(s) dépassé(s)
                                            @else
                                                {{ $certificat->jours_restants }} jour(s)
                                            @endif
                                        </span>
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($certificat->statut_visuel)
                                            @case('valide')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3"/>
                                                    </svg>
                                                    Valide
                                                </span>
                                                @break
                                            @case('expire_bientot')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3"/>
                                                    </svg>
                                                    Expire bientôt
                                                </span>
                                                @break
                                            @case('expire')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3"/>
                                                    </svg>
                                                    Expiré
                                                </span>
                                                @break
                                        @endswitch
                                    </td>

                                    <!-- Questionnaire santé -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($certificat->questionnaire_sante_requis)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                Requis
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                                Non requis
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.adherents.show', $certificat->adherent_id) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-150 font-medium"
                                               title="Voir l'adhérent">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Voir adhérent
                                            </a>
                                            @if($certificat->document_id)
                                                <a href="{{ route('admin.certificats.download', $certificat) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-cyan-100 text-cyan-700 rounded-lg hover:bg-cyan-200 transition-colors duration-150 font-medium"
                                                   title="Télécharger le certificat">
                                                    PDF
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                    {{ $certificats->links() }}
                </div>
            @endif
        </div>

        <!-- Statistiques rapides -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
            @php
                $totalCertificats = \App\Models\CertificatMedical::count();
                $valides = \App\Models\CertificatMedical::where('expire_le', '>', now()->addDays(30))->count();
                $expireBientot = \App\Models\CertificatMedical::where('expire_le', '>', now())->where('expire_le', '<=', now()->addDays(30))->count();
                $expires = \App\Models\CertificatMedical::where('expire_le', '<=', now())->count();
            @endphp

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-slate-100 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalCertificats }}</p>
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
                        <p class="text-sm font-medium text-slate-500">Valides</p>
                        <p class="text-2xl font-bold text-green-600">{{ $valides }}</p>
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
                        <p class="text-sm font-medium text-slate-500">Expire bientôt</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $expireBientot }}</p>
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
                        <p class="text-sm font-medium text-slate-500">Expirés</p>
                        <p class="text-2xl font-bold text-red-600">{{ $expires }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
