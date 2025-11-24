@extends('layouts.auth')

@section('title', 'Vérification 2FA')

@section('content')
<div style="width: 100%; max-width: 28rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2.25rem; font-weight: bold; color: #4338ca; margin-bottom: 0.5rem;">🏊 Lyon Palme</h1>
        <p style="color: #9ca3af;">Authentification à deux facteurs</p>
    </div>

    <!-- Card -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 1.5rem; text-align: center;">Confirmation requise</h2>

        <form method="POST" action="{{ route('two-factor.login') }}" style="display: grid; gap: 1.5rem;">
            @csrf

            <!-- Code d'authentification -->
            <div id="code-section">
                <label for="code" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Code d'authentification</label>
                <input
                    id="code"
                    type="text"
                    name="code"
                    inputmode="numeric"
                    maxlength="6"
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 2rem; letter-spacing: 0.1em; text-align: center; font-family: monospace;"
                    placeholder="000000"
                />
                @error('code')
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Code de récupération -->
            <div id="recovery-section" style="display: none;">
                <label for="recovery_code" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Code de récupération</label>
                <input
                    id="recovery_code"
                    type="text"
                    name="recovery_code"
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; font-family: monospace;"
                    placeholder="XXXXXXXX-XXXXXXXX"
                />
                @error('recovery_code')
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bouton submit -->
            <button
                type="submit"
                style="width: 100%; background: #4338ca; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;"
            >
                Vérifier
            </button>
        </form>

        <!-- Toggle Recovery -->
        <div style="margin-top: 1.5rem; text-align: center;">
            <button
                type="button"
                onclick="toggleRecovery()"
                style="font-size: 0.875rem; color: #4338ca; text-decoration: none; font-weight: 500; background: none; border: none; cursor: pointer;"
            >
                <span id="toggle-text">Utiliser un code de récupération</span>
            </button>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem; color: #9ca3af;">
        <p>Lyon Palme © 2025 - Gestion de Club</p>
    </div>
</div>

<script>
function toggleRecovery() {
    const codeSection = document.getElementById('code-section');
    const recoverySection = document.getElementById('recovery-section');
    const toggleText = document.getElementById('toggle-text');

    if (codeSection.style.display === 'none') {
        codeSection.style.display = 'block';
        recoverySection.style.display = 'none';
        toggleText.textContent = 'Utiliser un code de récupération';
    } else {
        codeSection.style.display = 'none';
        recoverySection.style.display = 'block';
        toggleText.textContent = 'Utiliser un code d\'authentification';
    }
}
</script>
@endsection
