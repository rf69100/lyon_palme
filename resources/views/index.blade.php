<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lyon Palme - Gestion de Club</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
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
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-xl text-slate-900">Lyon Palme</span>
                </div>
                <div class="flex gap-3">
                    <a href="/login" class="px-6 py-2 text-slate-700 hover:text-slate-900 font-medium">
                        Connexion
                    </a>
                    <a href="/register" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        S'inscrire
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center space-y-6">
                <div class="inline-block px-4 py-2 bg-blue-100 rounded-full text-blue-700 font-medium text-sm">
                    Système de Gestion Complet pour Clubs Aquatiques
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-slate-900 leading-tight">
                    Gérez votre club de plongée<br />
                    <span class="gradient-text">avec simplicité et sécurité</span>
                </h1>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                    Lyon Palme est une plateforme complète pour gérer adhérents, adhésions,
                    entraînements, compétitions et bien plus, tout en respectant les normes de sécurité CNIL & RGPD.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                    <a href="/dashboard" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold text-lg transition">
                        Accéder au Dashboard
                    </a>
                    <a href="#features" class="px-8 py-3 bg-white text-blue-600 rounded-lg border-2 border-blue-600 hover:bg-blue-50 font-bold text-lg transition">
                        Découvrir les fonctionnalités
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white/50 backdrop-blur-sm border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">100</div>
                    <div class="text-sm text-slate-600 mt-2">Adhérents</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">163</div>
                    <div class="text-sm text-slate-600 mt-2">Certifications</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">25</div>
                    <div class="text-sm text-slate-600 mt-2">Sorties</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">100%</div>
                    <div class="text-sm text-slate-600 mt-2">Sécurisé</div>
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
                <h3 class="font-bold text-lg text-slate-900 mb-2">Entraînements</h3>
                <p class="text-slate-600 text-sm">
                    Planification des séances, programmes personnalisés,
                    affectation des entraîneurs, suivi de la présence.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Compétitions</h3>
                <p class="text-slate-600 text-sm">
                    Organisation complète : modalités, inscriptions, résultats,
                    classements par catégorie d'âge et discipline.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Sorties Club</h3>
                <p class="text-slate-600 text-sm">
                    Planification de sorties (Marseille, Annecy, Port-Cros),
                    inscriptions, coûts, niveau requis, places limitées.
                </p>
            </div>

            <div class="card-hover bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-2">Matériel</h3>
                <p class="text-slate-600 text-sm">
                    Inventaire complet (palmes, masques, tubas, combinaisons),
                    prêts aux membres, suivi d'état, maintenance.
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
    <section class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <h2 class="text-4xl font-bold">Prêt à Commencer ?</h2>
            <p class="text-lg text-blue-100">
                Accédez au tableau de bord et commencez à gérer votre club dès maintenant.
            </p>
            <a href="/dashboard" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg hover:bg-blue-50 font-bold text-lg transition">
                → Accéder au Dashboard
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-white mb-4">Lyon Palme</h3>
                    <p class="text-sm text-slate-400">
                        Gestion complète pour clubs aquatiques
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Produit</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white">Fonctionnalités</a></li>
                        <li><a href="#" class="hover:text-white">Documentation</a></li>
                        <li><a href="#" class="hover:text-white">Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Sécurité</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">RGPD Compliant</a></li>
                        <li><a href="#" class="hover:text-white">CNIL Policy</a></li>
                        <li><a href="#" class="hover:text-white">Chiffrement E2E</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Légal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Politique de confidentialité</a></li>
                        <li><a href="#" class="hover:text-white">Conditions d'utilisation</a></li>
                        <li><a href="#" class="hover:text-white">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <p class="text-sm text-slate-400">
                        © 2024 Lyon Palme. Tous droits réservés.
                    </p>
                    <p class="text-sm text-slate-400 mt-4 sm:mt-0">
                        Développé avec ❤️ par Claude Code - Laravel 12 & MariaDB
                    </p>
                </div>
            </div>
        </div>
    </footer>

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
</body>
</html>
