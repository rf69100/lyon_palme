@extends('layouts.app')

@section('title', 'Dashboard Secrétaire - Lyon Palme')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Dashboard Secrétaire</h1>
            <p class="text-slate-600">Gestion administrative et statistiques du club</p>
        </div>

        <!-- Primary Statistics Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Members Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Adhérents actifs</p>
                        <p class="text-4xl font-bold text-slate-900 mt-2">{{ $totalMembers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/10 rounded-full flex items-center justify-center"><svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                </div>
                <p class="text-slate-500 text-xs mt-4">Membres actifs du club</p>
            </div>

            <!-- Adhesions Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Adhésions actives</p>
                        <p class="text-4xl font-bold text-slate-900 mt-2">{{ $activeAdhesions }}</p>
                    </div>
                    <div class="w-12 h-12 bg-cyan-500/10 rounded-full flex items-center justify-center"><svg class="w-6 h-6 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                </div>
                <p class="text-slate-500 text-xs mt-4">Adhésions valides</p>
            </div>

            <!-- Payments Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Paiements en attente</p>
                        <p class="text-4xl font-bold text-slate-900 mt-2">{{ $pendingPayments }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/10 rounded-full flex items-center justify-center"><svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                </div>
                <p class="text-slate-500 text-xs mt-4">À suivre</p>
            </div>

            <!-- Activities Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Activités planifiées</p>
                        <p class="text-4xl font-bold text-slate-900 mt-2">{{ $totalOutings + $totalCompetitions }}</p>
                    </div>
                    <div class="text-orange-500 text-3xl">🎯</div>
                </div>
                <p class="text-slate-500 text-xs mt-4">Sorties + Compétitions</p>
            </div>
        </div>

        <!-- Secondary Statistics Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Archived Members Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                <p class="text-slate-600 text-sm font-medium mb-2">Adhérents archivés</p>
                <p class="text-3xl font-bold text-slate-900">{{ $totalArchived }}</p>
            </div>

            <!-- Minors Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                <p class="text-slate-600 text-sm font-medium mb-2">Mineurs (avec responsables légaux)</p>
                <p class="text-3xl font-bold text-slate-900">{{ $totalMinors }}</p>
            </div>

            <!-- Expired Adhesions Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
                <p class="text-slate-600 text-sm font-medium mb-2">Adhésions expirées</p>
                <p class="text-3xl font-bold text-red-600">{{ $expiredAdhesions }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Expiring Adhesions Alert -->
                @if($expiringAdhesions->isNotEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <h2 class="text-lg font-bold text-yellow-900 mb-4">
                            ⚠️ Adhésions expirant dans les 30 prochains jours
                        </h2>
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                            @foreach($expiringAdhesions as $adhesion)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-yellow-100">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $adhesion->adherent->nom ?? 'N/A' }}
                                            {{ $adhesion->adherent->prenom ?? '' }}
                                        </p>
                                        <p class="text-xs text-slate-600">
                                            {{ $adhesion->typeAdhesion->nom ?? 'Type inconnu' }} -
                                            Saison {{ $adhesion->saison->nom ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-yellow-700">
                                            {{ $adhesion->date_fin->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs text-slate-600">
                                            {{ now()->diffInDays($adhesion->date_fin) }} j restants
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                        <p class="text-green-900 font-semibold">Aucune adhésion n'expire prochainement</p>
                    </div>
                @endif

                <!-- Recent Members -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Nouveaux adhérents (10 derniers)</h2>
                        <a href="#view-all" class="text-purple-600 text-sm font-semibold hover:text-purple-700">Voir tout →</a>
                    </div>

                    @if($recentMembers->isEmpty())
                        <p class="text-center text-slate-600 py-8">Aucun nouvel adhérent récemment</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-3 px-4 font-semibold text-slate-900">Nom</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-900">Email</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-900">Inscription</th>
                                        <th class="text-center py-3 px-4 font-semibold text-slate-900">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentMembers as $member)
                                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                            <td class="py-3 px-4">
                                                <span class="font-semibold text-slate-900">
                                                    {{ $member->nom }} {{ $member->prenom }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-slate-600">{{ $member->email }}</td>
                                            <td class="py-3 px-4 text-slate-600">
                                                {{ $member->cree_le?->format('d/m/Y') ?? 'N/A' }}
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                                    {{ $member->statut === 'actif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($member->statut) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admin Tools Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Actions rapides</h3>
                    <div class="space-y-2">
                        <a href="#add-member" class="block w-full bg-purple-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                            + Ajouter un adhérent
                        </a>
                        <a href="#manage-adhesions" class="block w-full bg-green-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                            📋 Gérer les adhésions
                        </a>
                        <a href="#view-payments" class="block w-full bg-purple-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                            💳 Suivi des paiements
                        </a>
                        <a href="#view-reports" class="block w-full bg-orange-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-orange-700 transition">
                            📊 Rapports & stats
                        </a>
                        <a href="#audit-logs" class="block w-full bg-slate-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-slate-700 transition">
                            🔍 Journaux d'audit
                        </a>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Santé du système</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Sauvegardes</span>
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Base de données</span>
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Encryption RGPD</span>
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Audit Trail</span>
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics -->
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-purple-900 mb-4">📊 Métriques clés</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-purple-800">Taux d'adhésion</span>
                            <span class="font-bold text-purple-900">
                                {{ $totalMembers > 0 ? round(($activeAdhesions / $totalMembers) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-purple-800">Mineurs / Total</span>
                            <span class="font-bold text-purple-900">
                                {{ $totalMembers > 0 ? round(($totalMinors / $totalMembers) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-purple-800">Paiements à jour</span>
                            <span class="font-bold text-purple-900">
                                {{ $totalPayments > 0 ? round((($totalPayments - $pendingPayments) / $totalPayments) * 100) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Help & Documentation -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">? Aide & Documentation</h3>
                    <div class="space-y-2 text-sm">
                        <a href="#" class="block text-purple-600 hover:text-purple-700 font-semibold">
                            → Guide de gestion
                        </a>
                        <a href="#" class="block text-purple-600 hover:text-purple-700 font-semibold">
                            → FAQ secrétaire
                        </a>
                        <a href="#" class="block text-purple-600 hover:text-purple-700 font-semibold">
                            → Contacter l'admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
