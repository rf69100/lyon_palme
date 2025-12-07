<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Support - Lyon Palme</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 min-h-screen">
  <!-- Navigation -->
  <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <span class="text-xl font-bold text-slate-900">Lyon Palme</span>
        </div>
        <div class="flex items-center space-x-4">
          <a href="/" class="text-slate-700 hover:text-slate-900 transition-colors">Accueil</a>
          @auth
            <a href="/dashboard" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-slate-900 transition-colors">
              Tableau de bord
            </a>
          @else
            <a href="/login" class="text-slate-700 hover:text-slate-900 transition-colors">Connexion</a>
            <a href="/register" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-slate-900 transition-colors">
              Inscription
            </a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-slate-900 mb-6">Support</h1>
        <p class="text-xl text-slate-600 max-w-3xl mx-auto">
          Notre équipe est là pour vous aider. Contactez-nous ou consultez nos ressources d'aide.
        </p>
      </div>
    </div>
  </div>

  <!-- Support Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-6xl mx-auto">
      <!-- Contact Methods -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 text-center">
          <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-900 mb-2">Email</h3>
          <p class="text-slate-600 mb-4">Réponse sous 24h</p>
          <a href="mailto:support@lyonpalme.fr" class="text-blue-500 hover:text-blue-400">support@lyonpalme.fr</a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 text-center">
          <div class="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-900 mb-2">Téléphone</h3>
          <p class="text-slate-600 mb-4">Lun-Ven 9h-18h</p>
          <a href="tel:+33123456789" class="text-green-500 hover:text-green-400">01 23 45 67 89</a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 text-center">
          <div class="w-16 h-16 bg-purple-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-900 mb-2">Chat en direct</h3>
          <p class="text-slate-600 mb-4">Disponible maintenant</p>
          <button class="text-purple-500 hover:text-purple-400">Démarrer le chat</button>
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
                <input type="email" class="w-full px-4 py-2 bg-slate-100 border border-slate-700 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="votre@email.fr">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Sujet</label>
              <select class="w-full px-4 py-2 bg-slate-100 border border-slate-700 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Question technique</option>
                <option>Problème de facturation</option>
                <option>Demande de fonctionnalité</option>
                <option>Bug ou erreur</option>
                <option>Autre</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Message</label>
              <textarea rows="6" class="w-full px-4 py-2 bg-slate-100 border border-slate-700 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Décrivez votre problème ou question..."></textarea>
            </div>

            <button type="submit" class="w-full px-6 py-3 bg-blue-500 hover:bg-blue-600 rounded-lg text-slate-900 font-medium transition-colors">
              Envoyer le message
            </button>
          </form>
        </div>
      </div>

      <!-- Knowledge Base -->
      <div class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-8 text-center">Base de connaissances</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <a href="/documentation" class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6 hover:border-blue-500 transition-colors group">
            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-500">Guide de démarrage</h3>
            <p class="text-slate-600">Apprenez les bases pour bien démarrer avec Lyon Palme</p>
          </a>

          <a href="/documentation" class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6 hover:border-blue-500 transition-colors group">
            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-500">Tutoriels vidéo</h3>
            <p class="text-slate-600">Regardez nos tutoriels pour maîtriser toutes les fonctionnalités</p>
          </a>

          <a href="/documentation" class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6 hover:border-blue-500 transition-colors group">
            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-500">Questions fréquentes</h3>
            <p class="text-slate-600">Trouvez rapidement des réponses aux questions courantes</p>
          </a>

          <a href="/documentation" class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6 hover:border-blue-500 transition-colors group">
            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-500">Mises à jour</h3>
            <p class="text-slate-600">Découvrez les nouvelles fonctionnalités et améliorations</p>
          </a>
        </div>
      </div>

      <!-- Hours -->
      <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-8">
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

  <!-- Footer -->
  <footer class="bg-white/80 backdrop-blur-sm border-t border-slate-200 py-12">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div>
          <h3 class="font-bold text-slate-900 mb-4">Lyon Palme</h3>
          <p class="text-sm text-slate-600">
            Club de palmage et plongée - FFESSM AURA<br>
            Centre Nautique de Saint-Fons<br>
            20 Rue des Frères Lumière, 69190 Saint-Fons
          </p>
        </div>
        <div>
          <h4 class="font-bold text-slate-900 mb-4">Produit</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="/#fonctionnalites" class="hover:text-slate-900">Fonctionnalités</a></li>
            <li><a href="/documentation" class="hover:text-slate-900">Documentation</a></li>
            <li><a href="/support" class="hover:text-slate-900">Support</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-slate-900 mb-4">Sécurité</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="/rgpd" class="hover:text-slate-900">RGPD</a></li>
            <li><a href="/cnil" class="hover:text-slate-900">Politique CNIL</a></li>
            <li><a href="/chiffrement" class="hover:text-slate-900">Chiffrement E2E</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-slate-900 mb-4">Légal</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="/confidentialite" class="hover:text-slate-900">Politique de confidentialité</a></li>
            <li><a href="/conditions" class="hover:text-slate-900">Conditions d'utilisation</a></li>
            <li><a href="/cookies" class="hover:text-slate-900">Cookies</a></li>
          </ul>
        </div>
      </div>
      <div class="border-t border-slate-200 pt-8 text-center text-sm text-slate-600">
        <p>&copy; 2024 Lyon Palme. Tous droits réservés.</p>
      </div>
    </div>
  </footer>
</body>
</html>
