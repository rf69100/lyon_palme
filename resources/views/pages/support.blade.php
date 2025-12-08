@extends('layouts.public')

@section('title', 'Support - Lyon Palme')

@section('content')
  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-white mb-6">Support</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto">
          Notre équipe est là pour vous aider. Contactez-nous ou consultez nos ressources d'aide.
        </p>
      </div>
    </div>
  </div>

  <!-- Support Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-6xl mx-auto">
      <!-- Contact Methods -->
      <div class="flex flex-wrap justify-center gap-8 mb-16 max-w-2xl mx-auto">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 text-center w-full md:w-80">
          <div class="w-16 h-16 bg-purple-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-900 mb-2">Email</h3>
          <p class="text-slate-600 mb-4">Réponse sous 24h</p>
          <a href="mailto:support@lyonpalme.fr" class="text-purple-500 hover:text-purple-400">support@lyonpalme.fr</a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 text-center w-full md:w-80">
          <div class="w-16 h-16 bg-cyan-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-900 mb-2">Téléphone</h3>
          <p class="text-slate-600 mb-4">Lun-Ven 9h-18h</p>
          <a href="tel:+33123456789" class="text-cyan-500 hover:text-cyan-400">01 23 45 67 89</a>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="max-w-2xl mx-auto mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-6">Envoyer un message</h2>
          <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nom</label>
                <input type="text" class="w-full px-4 py-2 bg-slate-100 border border-slate-700 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Votre nom">
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input type="email" class="w-full px-4 py-2 bg-slate-100 border border-slate-700 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="votre@email.com">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Sujet</label>
              <select class="w-full px-4 py-2 bg-slate-100 border border-slate-700 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Question générale</option>
                <option>Problème technique</option>
                <option>Demande de fonctionnalité</option>
                <option>Autre</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Message</label>
              <textarea rows="6" class="w-full px-4 py-2 bg-slate-100 border border-slate-700 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Décrivez votre problème ou question..."></textarea>
            </div>

            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-700 hover:to-cyan-600 rounded-lg text-white font-medium transition-colors">
              Envoyer le message
            </button>
          </form>
        </div>
      </div>

      
      <!-- Hours -->
      <div class="bg-gradient-to-r from-purple-500/10 to-cyan-500/10 border border-purple-500/20 rounded-xl p-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">Horaires du support</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
          <div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Support Email</h3>
            <p class="text-slate-600">24h/24, 7j/7</p>
            <p class="text-sm text-slate-500">Réponse sous 24h</p>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Support Téléphonique</h3>
            <p class="text-slate-600">Lundi - Vendredi</p>
            <p class="text-sm text-slate-500">9h00 - 18h00</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
