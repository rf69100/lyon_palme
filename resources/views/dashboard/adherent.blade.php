@extends('layouts.app')

@section('title', 'Mon Dashboard - Lyon Palme')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Bienvenue, {{ $stats['nom_complet'] }}</h1>
            <p class="text-slate-600">Gérez votre profil, adhésions et activités du club</p>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @if($stats['statut'] === 'actif')
                <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-lg font-semibold text-sm">
                    ✓ Membre actif
                </span>
            @else
                <span class="inline-block bg-gray-100 text-gray-800 px-4 py-2 rounded-lg font-semibold text-sm">
                    Compte inactif
                </span>
            @endif
        </div>

        <!-- Statistics Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Adhesions Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Adhésions</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['totalAdhesions'] ?? 0 }}</p>
                    </div>
                    <div class="text-blue-500 text-2xl">📋</div>
                </div>
                <p class="text-slate-500 text-xs mt-4">Memberships actifs et passés</p>
            </div>

            <!-- Activities Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Activités</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['activitesParticipees'] ?? 0 }}</p>
                    </div>
                    <div class="text-green-500 text-2xl">🏊</div>
                </div>
                <p class="text-slate-500 text-xs mt-4">Sorties auxquelles vous avez participé</p>
            </div>

            <!-- Certifications Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Certifications</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['certificationsCount'] ?? 0 }}</p>
                    </div>
                    <div class="text-purple-500 text-2xl">📜</div>
                </div>
                <p class="text-slate-500 text-xs mt-4">Niveaux et diplômes</p>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Profil</p>
                        <p class="text-slate-900 text-lg font-bold mt-2">Complet</p>
                    </div>
                    <div class="text-orange-500 text-2xl">👤</div>
                </div>
                <a href="#edit-profile" class="text-orange-500 text-xs font-semibold mt-4 inline-block hover:text-orange-600">
                    Modifier →
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Adhesions Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Mes Adhésions</h2>
                        <a href="#view-all" class="text-blue-600 text-sm font-semibold hover:text-blue-700">Voir tout →</a>
                    </div>

                    @if($adhesions->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-slate-600 mb-4">Aucune adhésion enregistrée</p>
                            <a href="#subscribe" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700">
                                S'adhérer maintenant
                            </a>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($adhesions as $adhesion)
                                <div class="flex items-center justify-between p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $adhesion->typeAdhesion->nom ?? 'Type inconnu' }}
                                        </p>
                                        <p class="text-sm text-slate-600">
                                            Saison {{ $adhesion->saison->nom ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $status = $adhesion->date_fin >= now() ? 'active' : 'expired';
                                        @endphp
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                            {{ $status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $status === 'active' ? 'Actif' : 'Expiré' }}
                                        </span>
                                        <p class="text-xs text-slate-600 mt-1">
                                            Jusqu'au {{ $adhesion->date_fin?->format('d/m/Y') ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Upcoming Outings Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Sorties à venir</h2>
                        <a href="#view-all" class="text-blue-600 text-sm font-semibold hover:text-blue-700">Voir tout →</a>
                    </div>

                    @if($upcomingOutings->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-slate-600">Aucune sortie prévue</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($upcomingOutings as $inscription)
                                <div class="flex items-center justify-between p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $inscription->sortie->titre ?? 'Sortie' }}
                                        </p>
                                        <p class="text-sm text-slate-600">
                                            📅 {{ $inscription->sortie->date_debut?->format('d/m/Y') ?? 'Date non définie' }}
                                        </p>
                                    </div>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Inscrit
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Upcoming Competitions Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Compétitions à venir</h2>
                        <a href="#view-all" class="text-blue-600 text-sm font-semibold hover:text-blue-700">Voir tout →</a>
                    </div>

                    @if($upcomingCompetitions->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-slate-600">Aucune compétition prévue</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($upcomingCompetitions as $inscription)
                                <div class="flex items-center justify-between p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $inscription->competition->nom ?? 'Compétition' }}
                                        </p>
                                        <p class="text-sm text-slate-600">
                                            🏆 {{ $inscription->competition->date_debut?->format('d/m/Y') ?? 'Date non définie' }}
                                        </p>
                                    </div>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Inscrit
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Actions rapides</h3>
                    <div class="space-y-2">
                        <a href="#edit-profile" class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Modifier mon profil
                        </a>
                        <a href="#change-password" class="block w-full bg-slate-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-slate-700 transition">
                            Changer mon mot de passe
                        </a>
                        <a href="#contact-support" class="block w-full bg-slate-200 text-slate-900 text-center py-2 rounded-lg font-semibold hover:bg-slate-300 transition">
                            Contacter le support
                        </a>
                    </div>
                </div>

                <!-- Important Info Card -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-blue-900 mb-3">💡 À savoir</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <span class="mr-2">✓</span>
                            <span>Vérifiez votre adhésion pour participer aux activités</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">✓</span>
                            <span>Mettez à jour votre profil régulièrement</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">✓</span>
                            <span>Consultez les certifications requises</span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">📞 Contact</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-slate-600 mb-1">Email</p>
                            <p class="text-slate-900 font-semibold">support@lyonpalme.fr</p>
                        </div>
                        <div>
                            <p class="text-slate-600 mb-1">Téléphone</p>
                            <p class="text-slate-900 font-semibold">04 72 XX XX XX</p>
                        </div>
                        <div>
                            <p class="text-slate-600 mb-1">Heures d'ouverture</p>
                            <p class="text-slate-900 font-semibold">Mar - Jeu: 18h-20h</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
