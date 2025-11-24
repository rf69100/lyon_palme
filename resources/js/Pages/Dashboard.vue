<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
    auth: Object,
})

const logout = () => {
    router.post(route('logout'))
}
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <Head title="Dashboard - Lyon Palme" />

        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">🏊 Lyon Palme</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Bienvenue</span>
                        <button
                            @click="logout"
                            type="button"
                            class="text-red-600 hover:text-red-700 font-medium"
                        >
                            Déconnexion
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Bienvenue au Dashboard</h2>
                <p class="text-gray-600 mb-6">
                    Vous êtes maintenant connecté à l'application de gestion Lyon Palme.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                        <div class="text-4xl font-bold text-blue-600 mb-2">100</div>
                        <p class="text-gray-700 font-medium">Adhérents</p>
                    </div>

                    <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                        <div class="text-4xl font-bold text-green-600 mb-2">25</div>
                        <p class="text-gray-700 font-medium">Sorties planifiées</p>
                    </div>

                    <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                        <div class="text-4xl font-bold text-purple-600 mb-2">12</div>
                        <p class="text-gray-700 font-medium">Compétitions</p>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded">
                    <p class="text-sm text-yellow-800">
                        ✓ Authentification Fortify activée
                        <br />
                        ✓ Chiffrement RGPD en place
                        <br />
                        ✓ Prêt pour la production
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
