<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="min-h-screen bg-white">
        <Head title="Accueil - Lyon Palme" />

        <!-- Navigation -->
        <nav class="flex justify-between items-center h-16 px-8 bg-white shadow-sm">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-indigo-600">🏊 Lyon Palme</h1>
            </div>
            <div class="flex items-center space-x-4">
                <Link :href="route('login')" class="px-4 py-2 text-indigo-600 hover:text-indigo-700 font-medium">
                    Connexion
                </Link>
                <Link :href="route('register')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">
                    S'inscrire
                </Link>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20 px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">Bienvenue à Lyon Palme</h2>
                <p class="text-xl text-gray-600 mb-8">
                    La plateforme complète de gestion pour votre club de plongée
                </p>
                <div class="flex justify-center gap-4">
                    <Link :href="route('register')" class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                        Commencer maintenant
                    </Link>
                    <Link :href="route('login')" class="px-8 py-3 bg-white text-indigo-600 border-2 border-indigo-600 rounded-lg hover:bg-indigo-50 font-semibold">
                        Se connecter
                    </Link>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 px-8">
            <div class="max-w-6xl mx-auto">
                <h3 class="text-3xl font-bold text-gray-900 mb-12 text-center">Nos fonctionnalités</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Gestion des adhérents -->
                    <div class="p-6 border-l-4 border-blue-600 bg-blue-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">👥 Gestion des adhérents</h4>
                        <p class="text-gray-600">
                            Gérez facilement vos adhérents, leurs certifications et leurs dossiers médicaux conformément à la RGPD.
                        </p>
                    </div>

                    <!-- Adhésions et paiements -->
                    <div class="p-6 border-l-4 border-green-600 bg-green-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">💳 Adhésions et paiements</h4>
                        <p class="text-gray-600">
                            Suivez les cotisations et paiements de vos membres avec un suivi complet et fiable.
                        </p>
                    </div>

                    <!-- Certificats médicaux -->
                    <div class="p-6 border-l-4 border-red-600 bg-red-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">🏥 Certificats médicaux</h4>
                        <p class="text-gray-600">
                            Conservez et gérez les certificats médicaux de manière sécurisée et conforme à la réglementation.
                        </p>
                    </div>

                    <!-- Certifications -->
                    <div class="p-6 border-l-4 border-purple-600 bg-purple-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">🎓 Certifications</h4>
                        <p class="text-gray-600">
                            Suivez les certifications et brevets de plongée de vos adhérents à jour.
                        </p>
                    </div>

                    <!-- Entraînement -->
                    <div class="p-6 border-l-4 border-yellow-600 bg-yellow-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">📚 Entraînement</h4>
                        <p class="text-gray-600">
                            Organisez des séances et programmes d'entraînement pour tous les niveaux.
                        </p>
                    </div>

                    <!-- Sorties et compétitions -->
                    <div class="p-6 border-l-4 border-indigo-600 bg-indigo-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">🌊 Sorties et compétitions</h4>
                        <p class="text-gray-600">
                            Planifiez et gérez les sorties en mer et les compétitions de votre club.
                        </p>
                    </div>

                    <!-- Matériel -->
                    <div class="p-6 border-l-4 border-orange-600 bg-orange-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">🔧 Gestion du matériel</h4>
                        <p class="text-gray-600">
                            Inventoriez et gérez l'équipement de plongée et d'entraînement du club.
                        </p>
                    </div>

                    <!-- Documents -->
                    <div class="p-6 border-l-4 border-cyan-600 bg-cyan-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">📄 Gestion des documents</h4>
                        <p class="text-gray-600">
                            Centralisez les documents importants du club en un seul endroit sécurisé.
                        </p>
                    </div>

                    <!-- Sécurité RGPD -->
                    <div class="p-6 border-l-4 border-pink-600 bg-pink-50 rounded-lg">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">🔐 Sécurité RGPD</h4>
                        <p class="text-gray-600">
                            Votre plateforme est entièrement conforme à la réglementation RGPD avec chiffrement de bout en bout.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-indigo-600 py-16 px-8 text-white">
            <div class="max-w-4xl mx-auto text-center">
                <h3 class="text-3xl font-bold mb-4">Prêt à gérer votre club ?</h3>
                <p class="text-lg mb-8 opacity-90">
                    Rejoignez les clubs de plongée qui font confiance à Lyon Palme
                </p>
                <Link :href="route('register')" class="inline-block px-8 py-3 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 font-semibold">
                    Créer un compte maintenant
                </Link>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-8 px-8">
            <div class="max-w-4xl mx-auto text-center">
                <p>&copy; 2025 Lyon Palme - Gestion de Club de Plongée. Tous droits réservés.</p>
                <p class="mt-2 text-sm">Conforme RGPD • Sécurisé • Fiable</p>
            </div>
        </footer>
    </div>
</template>
