@extends('layouts.auth')

@section('title', 'Confirmer le mot de passe')

@section('content')
<div style="width: 100%; max-width: 28rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2.25rem; font-weight: bold; color: #4338ca; margin-bottom: 0.5rem;">🏊 Lyon Palme</h1>
        <p style="color: #9ca3af;">Confirmation de sécurité</p>
    </div>

    <!-- Card -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 1rem; text-align: center;">Confirmez votre mot de passe</h2>
        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem; text-align: center;">
            Cette action requiert une confirmation de sécurité. Veuillez entrer votre mot de passe pour continuer.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" style="display: grid; gap: 1.5rem;">
            @csrf

            <!-- Mot de passe -->
            <div>
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autofocus
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                />
                @error('password')
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bouton submit -->
            <button
                type="submit"
                style="width: 100%; background: #4338ca; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;"
            >
                Confirmer
            </button>
        </form>
    </div>
</div>
@endsection
