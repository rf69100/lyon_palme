@extends('layouts.public')

@section('title', 'Lyon Palme - Gestion de Club')

@push('styles')
<style>
    .gradient-text {
        background: linear-gradient(135deg, #5DD9D2 0%, #5B4B8A 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center space-y-6">
                <div class="inline-block px-4 py-2 bg-purple-100 rounded-full text-purple-700 font-medium text-sm">
                    Club Lyon Palme - FFESSM Comité Régional AURA
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-slate-900 leading-tight">
                    Bienvenue au club<br />
                    <span class="gradient-text">Lyon Palme</span>
                </h1>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                    Plateforme de gestion interne du club Lyon Palme pour la gestion des adhérents, adhésions et plus encore.
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                    <a href="/about" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-bold text-lg transition">
                        À Propos
                    </a>
                    <a href="#features" class="px-8 py-3 bg-white text-purple-600 rounded-lg border-2 border-purple-600 hover:bg-purple-50 font-bold text-lg transition">
                        Découvrir les fonctionnalités
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center space-y-4 mb-16">
            <h2 class="text-4xl font-bold text-slate-900">
                Fonctionnalités Principales
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Tout ce dont vous avez besoin pour gérer efficacement votre club aquatique
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feature Cards -->
            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Gestion des Adhérents</h3>
                <p class="text-slate-600 text-sm">
                    Profils complets avec distinction mineurs/adultes, représentants légaux,
                    coordonnées chiffrées (RGPD), photos et notes.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Gestion des Adhésions</h3>
                <p class="text-slate-600 text-sm">
                    Types d'adhésion multiples, tarification par saison, suivi des paiements
                    échelonnés, calcul automatique des soldes.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Suivi Médical</h3>
                <p class="text-slate-600 text-sm">
                    Certificats médicaux avec alertes de validité, gestion des aptitudes,
                    conformité réglementaire pour la pratique sportive.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Certifications FFESSM</h3>
                <p class="text-slate-600 text-sm">
                    Niveaux de plongée (N1-N5, PE-12 à PE-60), apnée (A1-A4),
                    nage avec palmes (NP1-NP4), moniteurs (E1-E4, MF1-MF2).
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Documents</h3>
                <p class="text-slate-600 text-sm">
                    Stockage sécurisé des documents administratifs,
                    justificatifs, licences, assurances.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">RGPD & Sécurité</h3>
                <p class="text-slate-600 text-sm">
                    Champs sensibles chiffrés, consentements trackés,
                    journaux de connexion, réinitialisation sécurisée.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Rôles & Permissions</h3>
                <p class="text-slate-600 text-sm">
                    11 rôles (Président, Secrétaire, Trésorier, Moniteur, etc.),
                    annuaire du bureau avec contacts.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Statistiques</h3>
                <p class="text-slate-600 text-sm">
                    Vue consolidée des adhésions (validée, expirée, en attente),
                    rapports financiers, taux de présence.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-purple-600 to-cyan-500 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <h2 class="text-4xl font-bold">Prêt à Commencer ?</h2>
            <p class="text-lg text-purple-100">
                Créez votre compte dès aujourd'hui et simplifiez votre gestion avec Lyon Palme.
            </p>
            <a href="/dashboard" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg hover:bg-purple-50 font-bold text-lg transition">
                Je créer mon compte
            </a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
@endpush
