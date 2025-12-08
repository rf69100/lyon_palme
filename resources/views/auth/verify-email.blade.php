@extends('layouts.auth')

@section('title', 'Vérification d\'email')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="/LyonPalme.png" alt="Lyon Palme" class="h-16 mx-auto mb-4">
            <p class="text-slate-600">Vérification d'email requise</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">Vérifiez votre email</h2>
            <p class="text-slate-600 text-sm mb-6 text-center">
                Un lien de vérification a été envoyé à votre adresse email. Cliquez sur le lien dans l'email pour confirmer votre compte.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
                    Un nouveau lien de vérification a été envoyé à votre email.
                </div>
            @endif

            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
                Vous n'avez pas reçu le lien ? Cliquez sur le bouton ci-dessous pour en recevoir un nouveau.
            </div>

            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-cyan-500 text-white py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-cyan-600 transition duration-200"
                >
                    Renvoyer le lien
                </button>
            </form>

            <!-- Bouton déconnexion -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-red-50 text-red-600 py-2 rounded-lg font-semibold hover:bg-red-100 border border-red-200 transition duration-200"
                >
                    Se déconnecter
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-slate-600">
            <p class="mb-2">Besoin d'aide ?</p>
            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection
