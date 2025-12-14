@extends('layouts.public')

@section('title', 'À Propos - Lyon Palme')

@push('styles')
<style>
    .gradient-text {
        background: linear-gradient(135deg, #5DD9D2 0%, #5B4B8A 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endpush

@section('content')
  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-white mb-6">À Propos de Lyon Palme</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto">
          Découvrez notre histoire, nos valeurs et notre passion pour les activités aquatiques
        </p>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">

      <!-- Notre Histoire -->
      <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Notre Histoire</h2>
        <div class="space-y-4 text-slate-700 leading-relaxed">
          <p>
            <span class="font-bold text-purple-600">Lyon Palme</span> est un club affilié à la Fédération Française d'Études et de Sports Sous-Marins (FFESSM),
            membre du Comité Régional Auvergne-Rhône-Alpes (AURA). Nous sommes passionnés par les activités subaquatiques
            et le palmage sportif.
          </p>
          <p>
            Basé à Vénissieux, au cœur de la métropole lyonnaise, notre club accueille des pratiquants de tous niveaux,
            des débutants aux plongeurs confirmés, dans une ambiance conviviale et sécurisée.
          </p>
        </div>
      </div>

      <!-- Nos Activités -->
      <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Nos Activités</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6">
            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Plongée Sous-Marine</h3>
            <p class="text-slate-700 text-sm">
              Formation et pratique de la plongée bouteille, du niveau 1 au niveau 5,
              encadrée par des moniteurs diplômés FFESSM.
            </p>
          </div>

          <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg p-6">
            <div class="w-12 h-12 bg-cyan-500 rounded-full flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Nage avec Palmes</h3>
            <p class="text-slate-700 text-sm">
              Apprentissage et perfectionnement de la nage avec palmes, une discipline alliant technique et endurance.
            </p>
          </div>

          <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6">
            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Apnée</h3>
            <p class="text-slate-700 text-sm">
              Découverte et pratique de l'apnée, du niveau A1 à A4, pour apprendre à maîtriser sa respiration et son corps.
            </p>
          </div>

          <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6">
            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Formation</h3>
            <p class="text-slate-700 text-sm">
              Formations de moniteurs (E1 à E4, MF1, MF2) et préparation aux brevets fédéraux FFESSM.
            </p>
          </div>
        </div>
      </div>

      <!-- Nos Valeurs -->
      <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Nos Valeurs</h2>
        <div class="space-y-6">
          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-purple-500/10 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-1">Sécurité</h3>
              <p class="text-slate-600 text-sm">
                La sécurité de nos adhérents est notre priorité absolue. Tous nos encadrants sont diplômés
                et nous appliquons strictement les règles de sécurité de la FFESSM.
              </p>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-cyan-500/10 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-1">Convivialité</h3>
              <p class="text-slate-600 text-sm">
                Notre club cultive un esprit familial et convivial. Nous organisons régulièrement
                des sorties, des événements et des moments de partage entre membres.
              </p>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-purple-500/10 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
              </div>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-1">Excellence</h3>
              <p class="text-slate-600 text-sm">
                Nous encourageons nos adhérents à progresser et à se perfectionner dans leur pratique,
                avec un encadrement de qualité et un suivi personnalisé.
              </p>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-orange-500/10 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-1">Respect de l'Environnement</h3>
              <p class="text-slate-600 text-sm">
                Nous sensibilisons nos membres à la préservation du milieu aquatique et promouvons
                une pratique responsable et respectueuse de l'environnement.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Nos Installations -->
      <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Nos Installations</h2>
        <div class="space-y-4 text-slate-700 leading-relaxed">
          <p>
            Nous nous entraînons au <span class="font-semibold text-blue-600">Centre Nautique de Vénissieux</span>,
            situé au 16 Avenue du Docteur Georges Lévy, 69200 Vénissieux.
          </p>
          <p>
            Cette infrastructure moderne nous offre :
          </p>
          <ul class="list-disc list-inside space-y-2 ml-4">
            <li>Un bassin olympique de 50 mètres</li>
            <li>Une fosse de plongée de 20 mètres</li>
            <li>Des vestiaires spacieux et équipés</li>
            <li>Un local dédié pour le matériel du club</li>
            <li>Un accès facilité avec parking</li>
          </ul>
        </div>
      </div>

      <!-- Rejoignez-nous -->
      <div class="bg-gradient-to-r from-purple-600 to-cyan-500 rounded-xl p-8 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Rejoignez l'Aventure</h2>
        <p class="text-lg text-purple-100 mb-6 max-w-2xl mx-auto">
          Que vous soyez débutant ou plongeur expérimenté, Lyon Palme vous accueille
          pour partager votre passion des activités subaquatiques.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-purple-600 rounded-lg hover:bg-purple-50 font-bold transition">
            S'inscrire
          </a>
          <a href="{{ route('support') }}" class="px-8 py-3 bg-purple-500 text-white rounded-lg hover:bg-purple-400 font-bold transition border-2 border-white">
            Nous Contacter
          </a>
        </div>
      </div>

    </div>
  </div>
@endsection
