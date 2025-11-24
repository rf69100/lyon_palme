<script setup>
import { useForm } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    canResetPassword: Boolean,
})

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4">
        <Head title="Connexion - Lyon Palme" />

        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">🏊 Lyon Palme</h1>
                <p class="text-gray-600">Connexion à votre compte</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Se connecter</h2>

                <!-- Affichage des erreurs générales -->
                <div v-if="form.errors.email || form.errors.password" class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm text-red-600">
                    Identifiants invalides
                </div>

                <form @submit.prevent="submit" class="space-y-6">
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
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            :class="{ 'border-red-500': form.errors.password }"
                        />
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Se souvenir de moi -->
                    <div class="flex items-center">
                        <input
                            id="remember"
                            v-model="form.remember"
                            type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Bouton submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50"
                    >
                        <span v-if="form.processing">Connexion en cours...</span>
                        <span v-else>Se connecter</span>
                    </button>
                </form>

                <!-- Mot de passe oublié -->
                <div v-if="canResetPassword" class="mt-6 text-center">
                    <Link
                        :href="route('password.request')"
                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium"
                    >
                        Mot de passe oublié ?
                    </Link>
                </div>
            </div>

            <!-- Footer - Lien inscription -->
            <div class="mt-8 text-center text-sm text-gray-600">
                Pas encore de compte ?
                <Link :href="route('register')" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    S'inscrire
                </Link>
            </div>
        </div>
    </div>
</template>
