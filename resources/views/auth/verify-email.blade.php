@extends('layouts.auth')

@section('title', 'Vérification d\'email')

@section('content')
<div style="width: 100%; max-width: 28rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2.25rem; font-weight: bold; color: #4338ca; margin-bottom: 0.5rem;">🏊 Lyon Palme</h1>
        <p style="color: #9ca3af;">Vérification d'email requise</p>
    </div>

    <!-- Card -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 1rem; text-align: center;">Vérifiez votre email</h2>
        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem; text-align: center;">
            Un lien de vérification a été envoyé à votre adresse email. Cliquez sur le lien dans l'email pour confirmer votre compte.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f0fdf4; border: 1px solid #86efac; border-radius: 0.375rem; font-size: 0.875rem; color: #166534;">
                Un nouveau lien de vérification a été envoyé à votre email.
            </div>
        @endif

        <div style="margin-bottom: 1.5rem; padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.375rem; font-size: 0.875rem; color: #1e40af;">
            Vous n'avez pas reçu le lien ? Cliquez sur le bouton ci-dessous pour en recevoir un nouveau.
        </div>

        <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom: 1.5rem;">
            @csrf
            <button
                type="submit"
                style="width: 100%; background: #4338ca; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;"
            >
                Renvoyer le lien
            </button>
        </form>

        <!-- Bouton déconnexion -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                style="width: 100%; background: transparent; color: #dc2626; padding: 0.75rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: 1px solid #fecaca;"
            >
                Se déconnecter
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div style="margin-top: 2rem; text-align: center;">
        <p style="font-size: 0.875rem; color: #9ca3af; margin-bottom: 0.5rem;">Besoin d'aide ?</p>
        <a href="{{ route('login') }}" style="font-size: 0.875rem; color: #4338ca; text-decoration: none; font-weight: 500;">
            Retour à la connexion
        </a>
    </div>
</div>
@endsection
