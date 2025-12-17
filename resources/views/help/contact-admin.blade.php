@extends('layouts.app')

@section('title', 'Contacter l\'admin - Lyon Palme')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour au dashboard
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">✉️ Contacter l'administrateur</h1>
            <p class="text-slate-600">Besoin d'aide ? Envoyez un message à l'équipe administrative</p>
        </div>

        <!-- Contact Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <form method="POST" action="#" class="space-y-6">
                @csrf

                <!-- Sujet -->
                <div>
                    <label for="sujet" class="block text-sm font-semibold text-slate-700 mb-2">
                        Sujet de votre demande
                    </label>
                    <select
                        id="sujet"
                        name="sujet"
                        required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                        <option value="">Sélectionnez un sujet...</option>
                        <option value="adhesion">Question sur mon adhésion</option>
                        <option value="paiement">Problème de paiement</option>
                        <option value="activite">Question sur une sortie/activité</option>
                        <option value="materiel">Prêt de matériel</option>
                        <option value="technique">Problème technique</option>
                        <option value="autre">Autre demande</option>
                    </select>
                    @error('sujet')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-semibold text-slate-700 mb-2">
                        Votre message
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="8"
                        required
                        placeholder="Décrivez votre demande en détail..."
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-slate-500">
                        💡 Plus votre message est détaillé, plus nous pourrons vous aider rapidement
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    >
                        Envoyer le message
                    </button>
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex-1 bg-slate-100 text-slate-700 px-6 py-3 rounded-lg font-semibold hover:bg-slate-200 transition text-center"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-200">
            <h3 class="text-lg font-bold text-blue-900 mb-3">📞 Autres moyens de contact</h3>
            <div class="space-y-2 text-blue-900">
                <p><strong>Email direct:</strong> admin@lyonpalme.fr</p>
                <p><strong>Téléphone:</strong> 04 XX XX XX XX</p>
                <p><strong>Permanences:</strong> Mardi et Jeudi de 18h à 20h au local du club</p>
            </div>
        </div>

        <!-- Response Time Info -->
        <div class="mt-4 bg-yellow-50 rounded-xl p-6 border border-yellow-200">
            <h3 class="text-lg font-bold text-yellow-900 mb-3">⏱️ Délai de réponse</h3>
            <p class="text-yellow-900">
                Nous nous efforçons de répondre à toutes les demandes dans un délai de <strong>48 heures ouvrées</strong>.
                Pour les urgences, privilégiez le contact téléphonique.
            </p>
        </div>
    </div>
</div>
@endsection
