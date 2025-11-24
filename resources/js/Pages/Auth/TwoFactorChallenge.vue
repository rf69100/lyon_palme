<script setup>
import { useForm } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
    code: '',
    recovery_code: '',
})

const recovering = ref(false)

const submit = () => {
    form.post(route('two-factor.login'), {
        onFinish: () => form.reset('code', 'recovery_code'),
    })
}

const toggleRecovery = () => {
    recovering.value = !recovering.value
    form.reset('code', 'recovery_code')
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4">
        <Head title="Vérification 2FA - Lyon Palme" />

        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">🏊 Lyon Palme</h1>
                <p class="text-gray-600">Authentification à deux facteurs</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Confirmation requise</h2>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Code d'authentification -->
                    <div v-if="!recovering">
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            Code d'authentification
                        </label>
                        <input
                            id="code"
                            v-model="form.code"
                            type="text"
                            inputmode="numeric"
                            placeholder="000000"
                            autocomplete="off"
                            maxlength="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-center text-2xl tracking-widest font-mono"
                            :class="{ 'border-red-500': form.errors.code }"
                            required
                        />
                        <div v-if="form.errors.code" class="mt-1 text-sm text-red-600">
                            {{ form.errors.code }}
                        </div>
                    </div>

                    <!-- Code de récupération -->
                    <div v-else>
                        <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Code de récupération
                        </label>
                        <input
                            id="recovery_code"
                            v-model="form.recovery_code"
                            type="text"
                            placeholder="XXXXXXXX-XXXXXXXX"
                            autocomplete="off"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-mono"
                            :class="{ 'border-red-500': form.errors.recovery_code }"
                            required
                        />
                        <div v-if="form.errors.recovery_code" class="mt-1 text-sm text-red-600">
                            {{ form.errors.recovery_code }}
                        </div>
                    </div>

                    <!-- Bouton submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50"
                    >
                        <span v-if="form.processing">Vérification...</span>
                        <span v-else>Vérifier</span>
                    </button>
                </form>

                <!-- Toggle Recovery -->
                <div class="mt-6 text-center">
                    <button
                        @click="toggleRecovery"
                        type="button"
                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium"
                    >
                        <span v-if="!recovering">Utiliser un code de récupération</span>
                        <span v-else>Utiliser un code d'authentification</span>
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>Lyon Palme © 2025 - Gestion de Club</p>
            </div>
        </div>
    </div>
</template>
