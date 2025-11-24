<script setup>
import { useForm } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
    email: '',
})

const status = ref('')

const submit = () => {
    form.post(route('password.email'), {
        onSuccess: () => {
            status.value = 'Lien de réinitialisation envoyé avec succès. Vérifiez votre email.'
            form.reset()
        },
    })
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4">
        <Head title="Mot de passe oublié - Lyon Palme" />

        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">🏊 Lyon Palme</h1>
                <p class="text-gray-600">Réinitialiser votre mot de passe</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Mot de passe oublié ?</h2>
                <p class="text-gray-600 text-sm mb-6 text-center">
                    Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>

                <!-- Message de succès -->
                <div v-if="status" class="mb-4 p-3 bg-green-50 border border-green-200 rounded text-sm text-green-600">
                    {{ status }}
                </div>

                <!-- Message d'erreur -->
                <div v-if="form.errors.email" class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm text-red-600">
                    {{ form.errors.email }}
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
                    </div>

                    <!-- Bouton submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50"
                    >
                        <span v-if="form.processing">Envoi en cours...</span>
                        <span v-else>Envoyer le lien</span>
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <Link :href="route('login')" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Retour à la connexion
                </Link>
            </div>
        </div>
    </div>
</template>
