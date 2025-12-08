@extends('layouts.auth')

@section('title', 'Vérification 2FA')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="/LyonPalme.png" alt="Lyon Palme" class="h-16 mx-auto mb-4">
            <p class="text-slate-600">Authentification à deux facteurs</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">Confirmation requise</h2>

            <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5">
                @csrf

                <!-- Code d'authentification -->
                <div id="code-section">
                    <label for="code" class="block text-sm font-medium text-slate-700 mb-2">Code d'authentification</label>
                    <input
                        id="code"
                        type="text"
                        name="code"
                        inputmode="numeric"
                        maxlength="6"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg text-3xl tracking-widest text-center font-mono focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="000000"
                    />
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Code de récupération -->
                <div id="recovery-section" class="hidden">
                    <label for="recovery_code" class="block text-sm font-medium text-slate-700 mb-2">Code de récupération</label>
                    <input
                        id="recovery_code"
                        type="text"
                        name="recovery_code"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg font-mono focus:ring-2 focus:ring-purple-500 focus:border-transparent text-slate-900 placeholder-slate-400"
                        placeholder="XXXXXXXX-XXXXXXXX"
                    />
                    @error('recovery_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton submit -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-cyan-500 text-white py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-cyan-600 transition duration-200 mt-6"
                >
                    Vérifier
                </button>
            </form>

            <!-- Toggle Recovery -->
            <div class="mt-4 text-center">
                <button
                    type="button"
                    onclick="toggleRecovery()"
                    class="text-sm text-purple-600 hover:text-purple-700 font-medium bg-none border-none cursor-pointer"
                >
                    <span id="toggle-text">Utiliser un code de récupération</span>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-slate-600">
            <p>Lyon Palme © 2025 - Gestion de Club</p>
        </div>
    </div>
</div>

<script>
function toggleRecovery() {
    const codeSection = document.getElementById('code-section');
    const recoverySection = document.getElementById('recovery-section');
    const toggleText = document.getElementById('toggle-text');

    if (codeSection.classList.contains('hidden')) {
        codeSection.classList.remove('hidden');
        recoverySection.classList.add('hidden');
        toggleText.textContent = 'Utiliser un code de récupération';
    } else {
        codeSection.classList.add('hidden');
        recoverySection.classList.remove('hidden');
        toggleText.textContent = 'Utiliser un code d\'authentification';
    }
}
</script>
@endsection
