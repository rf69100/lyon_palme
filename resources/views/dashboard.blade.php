@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-4xl font-bold text-slate-900 mb-2">Bienvenue au Dashboard</h2>
        <p class="text-slate-600">Vous êtes maintenant connecté à l'application de gestion Lyon Palme.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Adhérents Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-600 text-sm font-medium">Adhérents</p>
                    <p class="text-4xl font-bold text-slate-900 mt-2">100</p>
                </div>
                <div class="text-blue-500 text-3xl">👥</div>
            </div>
            <p class="text-slate-500 text-xs mt-4">Membres inscrits</p>
        </div>

        <!-- Sorties planifiées Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-600 text-sm font-medium">Sorties planifiées</p>
                    <p class="text-4xl font-bold text-slate-900 mt-2">25</p>
                </div>
                <div class="text-green-500 text-3xl">🏊</div>
            </div>
            <p class="text-slate-500 text-xs mt-4">Activités à venir</p>
        </div>

        <!-- Compétitions Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 hover:shadow-xl transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-600 text-sm font-medium">Compétitions</p>
                    <p class="text-4xl font-bold text-slate-900 mt-2">12</p>
                </div>
                <div class="text-purple-500 text-3xl">🏆</div>
            </div>
            <p class="text-slate-500 text-xs mt-4">Événements prévus</p>
        </div>
    </div>

    <!-- Status Box -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
        <h3 class="text-lg font-bold text-green-900 mb-3">✓ Système opérationnel</h3>
        <ul class="space-y-2 text-sm text-green-800">
            <li class="flex items-center gap-2">
                <span class="text-green-600 font-bold">✓</span>
                <span>Authentification Fortify activée</span>
            </li>
            <li class="flex items-center gap-2">
                <span class="text-green-600 font-bold">✓</span>
                <span>Chiffrement RGPD en place</span>
            </li>
            <li class="flex items-center gap-2">
                <span class="text-green-600 font-bold">✓</span>
                <span>Prêt pour la production</span>
            </li>
        </ul>
    </div>
</div>
@endsection
