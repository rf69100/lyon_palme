@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div style="width: 100%; max-width: 28rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2.25rem; font-weight: bold; color: #4338ca; margin-bottom: 0.5rem;">🏊 Lyon Palme</h1>
        <p style="color: #9ca3af;">Connexion à votre compte</p>
    </div>

    <!-- Card -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 1.5rem; text-align: center;">Se connecter</h2>

        @if ($errors->any())
            <div style="margin-bottom: 1rem; padding: 0.75rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 0.375rem; font-size: 0.875rem; color: #991b1b;">
                Identifiants invalides
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="display: grid; gap: 1.5rem;">
            @csrf

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
                />
                @error('password')
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Se souvenir de moi -->
            <div style="display: flex; align-items: center;">
                <input id="remember" type="checkbox" name="remember" style="margin-right: 0.5rem;" />
                <label for="remember" style="font-size: 0.875rem; color: #374151;">Se souvenir de moi</label>
            </div>

            <!-- Bouton submit -->
            <button
                type="submit"
                style="width: 100%; background: #4338ca; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;"
            >
                Se connecter
            </button>
        </form>

        <!-- Mot de passe oublié -->
        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: #4338ca; text-decoration: none; font-weight: 500;">
                Mot de passe oublié ?
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem; color: #9ca3af;">
        Pas encore de compte ?
        <a href="{{ route('register') }}" style="color: #4338ca; text-decoration: none; font-weight: 500;">S'inscrire</a>
    </div>
</div>
@endsection
