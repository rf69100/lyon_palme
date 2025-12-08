@extends('layouts.public')

@section('title', 'Politique des Cookies - Lyon Palme')

@section('content')

  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-white mb-6">Politique des cookies</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto">
          Comment nous utilisons les cookies et technologies similaires
        </p>
        <p class="text-sm text-slate-300 mt-4">Dernière mise à jour : Décembre 2024</p>
      </div>
    </div>
  </div>

  <!-- Cookies Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">
      <!-- Introduction -->
      <section class="mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Qu'est-ce qu'un cookie ?</h2>
          <p class="text-slate-600 mb-4">
            Un cookie est un petit fichier texte déposé sur votre terminal (ordinateur, smartphone, tablette) lors de la visite d'un site web. Les cookies permettent au site de mémoriser des informations sur votre visite, comme votre langue préférée et d'autres paramètres.
          </p>
          <p class="text-slate-600">
            Cette page explique quels types de cookies nous utilisons, pourquoi nous les utilisons et comment vous pouvez les contrôler.
          </p>
        </div>
      </section>

      <!-- Types de cookies -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Types de cookies que nous utilisons</h2>

        <div class="space-y-6">
          <!-- Cookies strictement nécessaires -->
          <div class="bg-white/80 backdrop-blur-sm border border-green-800 rounded-xl p-6">
            <div class="flex items-start justify-between mb-4">
              <h3 class="text-xl font-bold text-slate-900">1. Cookies strictement nécessaires</h3>
              <span class="px-3 py-1 bg-green-500/10 border border-green-500/20 rounded-full text-green-500 text-xs font-medium">
                Obligatoire
              </span>
            </div>
            <p class="text-slate-600 mb-4">
              Ces cookies sont essentiels au fonctionnement de la plateforme. Sans eux, vous ne pourriez pas utiliser nos services.
            </p>

            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-3">Exemples :</h4>
              <div class="space-y-3">
                <div>
                  <p class="text-slate-900 text-sm mb-1">Cookie de session (PHPSESSID)</p>
                  <p class="text-slate-600 text-xs">Maintient votre connexion active pendant votre navigation</p>
                  <p class="text-slate-500 text-xs mt-1">Durée : Session (supprimé à la fermeture du navigateur)</p>
                </div>
                <div>
                  <p class="text-slate-900 text-sm mb-1">Cookie CSRF</p>
                  <p class="text-slate-600 text-xs">Protège contre les attaques de type Cross-Site Request Forgery</p>
                  <p class="text-slate-500 text-xs mt-1">Durée : Session</p>
                </div>
                <div>
                  <p class="text-slate-900 text-sm mb-1">Cookie d'authentification</p>
                  <p class="text-slate-600 text-xs">Mémorise votre statut de connexion</p>
                  <p class="text-slate-500 text-xs mt-1">Durée : 30 jours ou jusqu'à déconnexion</p>
                </div>
              </div>
            </div>

            <p class="text-slate-500 text-sm mt-4">
              Ces cookies ne peuvent pas être désactivés car la plateforme ne fonctionnerait pas correctement sans eux.
            </p>
          </div>

          <!-- Cookies de préférences -->
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <div class="flex items-start justify-between mb-4">
              <h3 class="text-xl font-bold text-slate-900">2. Cookies de préférences</h3>
              <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-full text-blue-500 text-xs font-medium">
                Facultatif
              </span>
            </div>
            <p class="text-slate-600 mb-4">
              Ces cookies permettent à la plateforme de mémoriser vos choix et préférences pour améliorer votre expérience.
            </p>

            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-3">Exemples :</h4>
              <div class="space-y-3">
                <div>
                  <p class="text-slate-900 text-sm mb-1">Langue préférée</p>
                  <p class="text-slate-600 text-xs">Mémorise votre choix de langue</p>
                  <p class="text-slate-500 text-xs mt-1">Durée : 12 mois</p>
                </div>
                <div>
                  <p class="text-slate-900 text-sm mb-1">Préférences d'affichage</p>
                  <p class="text-slate-600 text-xs">Mémorise vos préférences de mise en page, taille de police, etc.</p>
                  <p class="text-slate-500 text-xs mt-1">Durée : 12 mois</p>
                </div>
                <div>
                  <p class="text-slate-900 text-sm mb-1">Consentement cookies</p>
                  <p class="text-slate-600 text-xs">Mémorise vos choix concernant les cookies</p>
                  <p class="text-slate-500 text-xs mt-1">Durée : 13 mois</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Cookies analytiques -->
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <div class="flex items-start justify-between mb-4">
              <h3 class="text-xl font-bold text-slate-900">3. Cookies analytiques</h3>
              <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-full text-blue-500 text-xs font-medium">
                Facultatif
              </span>
            </div>
            <p class="text-slate-600 mb-4">
              Ces cookies nous aident à comprendre comment les utilisateurs interagissent avec la plateforme afin de l'améliorer.
            </p>

            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-3">Informations collectées :</h4>
              <ul class="list-disc list-inside text-slate-600 text-sm space-y-2">
                <li>Pages visitées et temps passé sur chaque page</li>
                <li>Parcours de navigation</li>
                <li>Type d'appareil et navigateur utilisé</li>
                <li>Résolution d'écran</li>
                <li>Source de trafic (comment vous êtes arrivé sur notre site)</li>
              </ul>
              <p class="text-slate-500 text-xs mt-4">
                Durée : 13 mois maximum
              </p>
            </div>

            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mt-4">
              <p class="text-slate-700 text-sm">
                Toutes les données analytiques sont anonymisées et agrégées. Nous n'identifions jamais personnellement les utilisateurs via ces cookies.
              </p>
            </div>
          </div>

          <!-- Cookies de performance -->
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <div class="flex items-start justify-between mb-4">
              <h3 class="text-xl font-bold text-slate-900">4. Cookies de performance</h3>
              <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-full text-blue-500 text-xs font-medium">
                Facultatif
              </span>
            </div>
            <p class="text-slate-600 mb-4">
              Ces cookies nous permettent de mesurer et d'améliorer les performances de la plateforme.
            </p>

            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-3">Utilisation :</h4>
              <ul class="list-disc list-inside text-slate-600 text-sm space-y-2">
                <li>Mesure des temps de chargement des pages</li>
                <li>Détection des erreurs techniques</li>
                <li>Optimisation de la vitesse de la plateforme</li>
                <li>Surveillance de la disponibilité du service</li>
              </ul>
              <p class="text-slate-500 text-xs mt-4">
                Durée : 24 heures
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Ce que nous ne faisons pas -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Ce que nous NE faisons PAS</h2>
        <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-8">
          <ul class="space-y-3">
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="text-slate-700">Nous n'utilisons pas de cookies publicitaires tiers</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="text-slate-700">Nous ne partageons pas vos données avec des régies publicitaires</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="text-slate-700">Nous ne vendons jamais vos données à des tiers</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="text-slate-700">Nous ne créons pas de profils utilisateurs à des fins marketing</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="text-slate-700">Nous ne suivons pas votre navigation sur d'autres sites web</span>
            </li>
          </ul>
        </div>
      </section>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Via votre navigateur</h3>
            <p class="text-slate-600 mb-4">
              Vous pouvez également configurer votre navigateur pour refuser tous les cookies ou uniquement les cookies tiers.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="bg-slate-50 rounded-lg p-4">
                <h4 class="font-semibold text-slate-900 mb-2">Google Chrome</h4>
                <p class="text-slate-600 text-sm">Paramètres → Confidentialité et sécurité → Cookies</p>
              </div>
              <div class="bg-slate-50 rounded-lg p-4">
                <h4 class="font-semibold text-slate-900 mb-2">Firefox</h4>
                <p class="text-slate-600 text-sm">Paramètres → Vie privée et sécurité → Cookies</p>
              </div>
              <div class="bg-slate-50 rounded-lg p-4">
                <h4 class="font-semibold text-slate-900 mb-2">Safari</h4>
                <p class="text-slate-600 text-sm">Préférences → Confidentialité → Cookies</p>
              </div>
              <div class="bg-slate-50 rounded-lg p-4">
                <h4 class="font-semibold text-slate-900 mb-2">Edge</h4>
                <p class="text-slate-600 text-sm">Paramètres → Cookies et autorisations</p>
              </div>
            </div>

            <div class="bg-orange-500/10 border border-orange-500/20 rounded-lg p-4 mt-6">
              <p class="text-slate-700 text-sm">
                <strong class="text-slate-900">Attention :</strong> La désactivation de tous les cookies peut affecter le fonctionnement de la plateforme et certaines fonctionnalités pourraient ne plus être disponibles.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Cookies tiers -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Cookies tiers</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Nous utilisons un nombre limité de services tiers qui peuvent déposer leurs propres cookies :
          </p>

          <div class="space-y-4">
            <div class="bg-slate-50 rounded-lg p-4">
              <div class="flex items-start justify-between mb-2">
                <h4 class="font-semibold text-slate-900">CDN (Content Delivery Network)</h4>
                <span class="text-xs text-slate-500">Performance</span>
              </div>
              <p class="text-slate-600 text-sm mb-2">
                Utilisé pour améliorer les temps de chargement de la plateforme.
              </p>
              <p class="text-slate-500 text-xs">
                Aucune donnée personnelle n'est transmise.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Conformité RGPD -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Conformité RGPD</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-4">
            Notre utilisation des cookies est conforme au Règlement Général sur la Protection des Données (RGPD) et aux recommandations de la CNIL :
          </p>

          <ul class="space-y-3">
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600">Consentement préalable pour les cookies non essentiels</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600">Information claire et transparente sur leur utilisation</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600">Possibilité de retirer votre consentement à tout moment</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600">Durée de conservation limitée (13 mois maximum)</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600">Pas de cookies muraille (cookie walls)</span>
            </li>
          </ul>
        </div>
      </section>

      <!-- Mises à jour -->
      <section class="mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Mises à jour de cette politique</h2>
          <p class="text-slate-600 mb-4">
            Nous pouvons mettre à jour cette politique des cookies de temps en temps. Toute modification sera publiée sur cette page avec une nouvelle date de mise à jour.
          </p>
          <p class="text-slate-600">
            Nous vous encourageons à consulter régulièrement cette page pour rester informé de nos pratiques en matière de cookies.
          </p>
        </div>
      </section>

      <!-- Contact -->
      <section>
        <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Des questions sur les cookies ?</h2>
          <p class="text-slate-600 mb-6">
            Pour toute question concernant notre utilisation des cookies, vous pouvez nous contacter :
          </p>
          <div class="space-y-2 text-slate-700">
            <p>Email : <a href="mailto:dpo@lyonpalme.fr" class="text-blue-400 hover:text-blue-300">dpo@lyonpalme.fr</a></p>
            <p>Support : <a href="/support" class="text-blue-400 hover:text-blue-300">Page de support</a></p>
          </div>
        </div>
      </section>
    </div>
  </div>

@endsection
