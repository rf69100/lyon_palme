<script setup>
import { useForm } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({})
const status = ref('')

const submit = () => {
    form.post(route('verification.send'), {
        onSuccess: () => {
            status.value = 'Un nouveau lien de vérification a été envoyé à votre email.'
        },
    })
}

const logout = () => {
    useForm({}).post(route('logout'))
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4">
        <Head title="Vérification d'email - Lyon Palme" />

        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">🏊 Lyon Palme</h1>
                <p class="text-gray-600">Vérification d'email requise</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Vérifiez votre email</h2>
                <p class="text-gray-600 text-sm mb-6 text-center">
                    Un lien de vérification a été envoyé à votre adresse email. Cliquez sur le lien dans l'email pour confirmer votre compte.
                </p>

                <!-- Message de succès -->
                <div v-if="status" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                    {{ status }}
                </div>

                <!-- Message informatif -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700">
                    Vous n'avez pas reçu le lien ? Cliquez sur le bouton ci-dessous pour en recevoir un nouveau.
                </div>

                <!-- Bouton pour renvoyer l'email -->
                <form @submit.prevent="submit">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50"
                    >
                        <span v-if="form.processing">Envoi en cours...</span>
                        <span v-else>Renvoyer le lien</span>
                    </button>
                </form>

                <!-- Bouton déconnexion -->
                <div class="mt-6">
                    <button
                        @click="logout"
                        type="button"
                        class="w-full text-red-600 hover:text-red-700 font-medium text-sm py-2"
                    >
                        Se déconnecter
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>Besoin d'aide ?</p>
                <Link :href="route('login')" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Retour à la connexion
                </Link>
            </div>
        </div>
    </div>
</template>
