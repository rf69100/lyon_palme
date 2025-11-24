<script setup>
import { useForm } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3'

const form = useForm({
    nom: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4">
        <Head title="Inscription - Lyon Palme" />

        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">🏊 Lyon Palme</h1>
                <p class="text-gray-600">Créer votre compte</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">S'inscrire</h2>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom complet
                        </label>
                        <input
                            id="nom"
                            v-model="form.nom"
                            type="text"
                            placeholder="Votre nom complet"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            :class="{ 'border-red-500': form.errors.nom }"
                        />
                        <div v-if="form.errors.nom" class="mt-1 text-sm text-red-600">
                            {{ form.errors.nom }}
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="votre@email.com"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            :class="{ 'border-red-500': form.errors.email }"
                        />
                        <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="Au moins 8 caractères"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            :class="{ 'border-red-500': form.errors.password }"
                        />
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="Confirmez votre mot de passe"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            :class="{ 'border-red-500': form.errors.password_confirmation }"
                        />
                        <div v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password_confirmation }}
                        </div>
                    </div>

                    <!-- Bouton submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50"
                    >
                        <span v-if="form.processing">Inscription en cours...</span>
                        <span v-else>S'inscrire</span>
                    </button>
                </form>
            </div>

            <!-- Footer - Lien connexion -->
            <div class="mt-8 text-center text-sm text-gray-600">
                Déjà inscrit ?
                <Link :href="route('login')" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Se connecter
                </Link>
            </div>
        </div>
    </div>
</template>
