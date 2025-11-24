@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div style="width: 100%; max-width: 28rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2.25rem; font-weight: bold; color: #4338ca; margin-bottom: 0.5rem;">🏊 Lyon Palme</h1>
        <p style="color: #9ca3af;">Créer votre compte</p>
    </div>

    <!-- Card -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 1.5rem; text-align: center;">S'inscrire</h2>

        <form method="POST" action="{{ route('register') }}" style="display: grid; gap: 1.25rem;">
            @csrf

            <!-- Nom -->
            <div>
                <label for="nom" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Nom complet</label>
                <input
                    id="nom"
                    type="text"
                    name="nom"
                    value="{{ old('nom') }}"
                    required
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                    placeholder="Votre nom complet"
                />
                @error('nom')
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                    placeholder="votre@email.com"
                />
                @error('email')
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                    placeholder="Au moins 8 caractères"
                />
                @error('password')
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirmation mot de passe -->
            <div>
                <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Confirmer le mot de passe</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;"
                    placeholder="Confirmez votre mot de passe"
                />
            </div>

            <!-- Bouton submit -->
            <button
                type="submit"
                style="width: 100%; background: #4338ca; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;"
            >
                S'inscrire
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem; color: #9ca3af;">
        Déjà inscrit ?
        <a href="{{ route('login') }}" style="color: #4338ca; text-decoration: none; font-weight: 500;">Se connecter</a>
    </div>
</div>
@endsection
