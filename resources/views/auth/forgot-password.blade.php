@extends('layouts.auth')

@section('title', 'Mot de passe oublié')

@section('content')
<div style="width: 100%; max-width: 28rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2.25rem; font-weight: bold; color: #4338ca; margin-bottom: 0.5rem;">🏊 Lyon Palme</h1>
        <p style="color: #9ca3af;">Réinitialiser votre mot de passe</p>
    </div>

    <!-- Card -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 1rem; text-align: center;">Mot de passe oublié ?</h2>
        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem; text-align: center;">
            Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        @if (session('status'))
            <div style="margin-bottom: 1rem; padding: 0.75rem; background: #f0fdf4; border: 1px solid #86efac; border-radius: 0.375rem; font-size: 0.875rem; color: #166534;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" style="display: grid; gap: 1.5rem;">
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

            <!-- Bouton submit -->
            <button
                type="submit"
                style="width: 100%; background: #4338ca; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;"
            >
                Envoyer le lien
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div style="margin-top: 2rem; text-align: center;">
        <a href="{{ route('login') }}" style="font-size: 0.875rem; color: #4338ca; text-decoration: none; font-weight: 500;">
            Retour à la connexion
        </a>
    </div>
</div>
@endsection
