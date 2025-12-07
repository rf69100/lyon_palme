<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Documentation - Lyon Palme</title>
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
        <h1 class="text-5xl font-bold text-slate-900 mb-6">Documentation</h1>
        <p class="text-xl text-slate-600 max-w-3xl mx-auto">
          Tout ce que vous devez savoir pour utiliser Lyon Palme efficacement
        </p>
      </div>
    </div>
  </div>

  <!-- Documentation Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">
      <!-- Getting Started -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Démarrage rapide</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h3 class="text-xl font-bold text-slate-900 mb-4">1. Créer votre compte</h3>
          <p class="text-slate-600 mb-6">
            Commencez par créer un compte administrateur pour votre club. Vous recevrez un email de confirmation pour activer votre compte.
          </p>

          <h3 class="text-xl font-bold text-slate-900 mb-4">2. Configurer votre club</h3>
          <p class="text-slate-600 mb-6">
            Renseignez les informations de votre club : nom, adresse, coordonnées, logo, etc. Ces informations apparaîtront sur tous vos documents officiels.
          </p>

          <h3 class="text-xl font-bold text-slate-900 mb-4">3. Ajouter vos membres</h3>
          <p class="text-slate-600 mb-6">
            Importez votre liste de membres existante ou ajoutez-les un par un. Vous pouvez également permettre aux membres de s'inscrire directement en ligne.
          </p>

          <h3 class="text-xl font-bold text-slate-900 mb-4">4. Planifier vos activités</h3>
          <p class="text-slate-600">
            Créez vos groupes, planifiez vos entraînements et compétitions, et commencez à gérer votre club de manière efficace.
          </p>
        </div>
      </section>

      <!-- Features Guide -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Guide des fonctionnalités</h2>

        <div class="space-y-6">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Gestion des membres</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Fiches membres complètes avec photos et documents</li>
              <li>Gestion des licences et certificats médicaux</li>
              <li>Historique des paiements et cotisations</li>
              <li>Import/export de listes de membres</li>
              <li>Communication directe par email ou SMS</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Planning et entraînements</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Calendrier interactif des entraînements</li>
              <li>Gestion des groupes et niveaux</li>
              <li>Attribution automatique des bassins et créneaux</li>
              <li>Feuilles de présence électroniques</li>
              <li>Suivi de la progression des nageurs</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Compétitions</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Inscription aux compétitions en ligne</li>
              <li>Gestion des engagements FFN</li>
              <li>Suivi des performances et records personnels</li>
              <li>Statistiques et analyses de résultats</li>
              <li>Génération automatique des convocations</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Comptabilité</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Gestion des cotisations et paiements</li>
              <li>Facturation automatique</li>
              <li>Suivi des impayés et relances</li>
              <li>Paiement en ligne sécurisé</li>
              <li>Rapports financiers détaillés</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- FAQ -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Questions fréquentes</h2>
        <div class="space-y-4">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Comment importer ma liste de membres existante ?</h3>
            <p class="text-slate-600">
              Vous pouvez importer vos membres via un fichier CSV ou Excel. Un modèle est disponible dans l'espace d'administration pour vous guider.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Est-ce que les membres peuvent consulter leur espace personnel ?</h3>
            <p class="text-slate-600">
              Oui, chaque membre dispose d'un espace personnel où il peut consulter ses informations, son planning, ses résultats et effectuer ses paiements.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Puis-je personnaliser les documents générés ?</h3>
            <p class="text-slate-600">
              Absolument ! Vous pouvez personnaliser tous les documents (attestations, factures, convocations) avec votre logo et vos couleurs.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Les données sont-elles sauvegardées ?</h3>
            <p class="text-slate-600">
              Toutes vos données sont automatiquement sauvegardées quotidiennement. Vous pouvez également effectuer des exports manuels à tout moment.
            </p>
          </div>
        </div>
      </section>

      <!-- Support -->
      <section class="mb-16">
        <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-8 text-center">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Besoin d'aide supplémentaire ?</h2>
          <p class="text-slate-600 mb-6">
            Notre équipe support est disponible pour répondre à toutes vos questions
          </p>
          <a href="/support" class="inline-block px-6 py-3 bg-blue-500 hover:bg-blue-600 rounded-lg text-slate-900 transition-colors">
            Contacter le support
          </a>
        </div>
      </section>
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
