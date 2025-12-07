<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Politique CNIL - Lyon Palme</title>
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
        <h1 class="text-5xl font-bold text-slate-900 mb-6">Politique CNIL</h1>
        <p class="text-xl text-slate-600 max-w-3xl mx-auto">
          Respect de la législation française en matière de protection des données personnelles
        </p>
      </div>
    </div>
  </div>

  <!-- CNIL Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">
      <!-- Introduction -->
      <section class="mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">À propos de la CNIL</h2>
          <p class="text-slate-600 mb-4">
            La Commission Nationale de l'Informatique et des Libertés (CNIL) est l'autorité française de protection des données personnelles. Elle veille au respect de la loi Informatique et Libertés et du RGPD sur le territoire français.
          </p>
          <p class="text-slate-600">
            Lyon Palme s'engage à respecter l'ensemble des recommandations et obligations fixées par la CNIL pour garantir la protection de vos données personnelles.
          </p>
        </div>
      </section>

      <!-- Déclaration -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Notre déclaration CNIL</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <div class="flex items-start space-x-4 mb-6">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-green-500/10 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <div>
              <h3 class="text-xl font-bold text-slate-900 mb-2">Traitement déclaré</h3>
              <p class="text-slate-600">
                Nos traitements de données personnelles sont conformes aux exigences de la CNIL. En tant que responsable de traitement, nous avons mis en place toutes les mesures nécessaires pour garantir la protection de vos données.
              </p>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Responsable de traitement</h4>
              <p class="text-slate-600 text-sm">Lyon Palme</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Finalité</h4>
              <p class="text-slate-600 text-sm">Gestion de club sportif</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Base légale</h4>
              <p class="text-slate-600 text-sm">Consentement et exécution du contrat</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Localisation</h4>
              <p class="text-slate-600 text-sm">Données hébergées en France</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Finalités -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Finalités des traitements</h2>
        <div class="space-y-4">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Gestion des adhésions</h3>
            <p class="text-slate-600 mb-3">
              Création et mise à jour des fiches membres, gestion des licences sportives, suivi des certificats médicaux.
            </p>
            <div class="text-sm">
              <span class="text-slate-500">Base légale :</span>
              <span class="text-slate-700"> Exécution du contrat d'adhésion</span>
            </div>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Gestion des paiements</h3>
            <p class="text-slate-600 mb-3">
              Facturation, encaissement des cotisations, suivi des règlements, relances des impayés.
            </p>
            <div class="text-sm">
              <span class="text-slate-500">Base légale :</span>
              <span class="text-slate-700"> Exécution du contrat et obligation légale</span>
            </div>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Organisation des activités</h3>
            <p class="text-slate-600 mb-3">
              Planning des entraînements, gestion des groupes, suivi des présences, organisation des compétitions.
            </p>
            <div class="text-sm">
              <span class="text-slate-500">Base légale :</span>
              <span class="text-slate-700"> Exécution du contrat</span>
            </div>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Communication</h3>
            <p class="text-slate-600 mb-3">
              Envoi d'informations relatives à la vie du club, convocations, résultats sportifs.
            </p>
            <div class="text-sm">
              <span class="text-slate-500">Base légale :</span>
              <span class="text-slate-700"> Intérêt légitime et consentement</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Durées de conservation -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Durées de conservation</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Conformément aux recommandations de la CNIL, nous conservons vos données pour les durées suivantes :
          </p>

          <div class="space-y-4">
            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Données d'adhésion</p>
                <p class="text-slate-600 text-sm">Durée de l'adhésion + 3 ans (prescriptions légales)</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Données comptables</p>
                <p class="text-slate-600 text-sm">10 ans (obligation légale)</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Certificats médicaux</p>
                <p class="text-slate-600 text-sm">Durée de validité + 1 an</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Résultats sportifs</p>
                <p class="text-slate-600 text-sm">Durée de l'adhésion + 3 ans (archives historiques)</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Logs de connexion</p>
                <p class="text-slate-600 text-sm">1 an maximum</p>
              </div>
            </div>
          </div>

          <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mt-6">
            <p class="text-slate-700 text-sm">
              À l'issue de ces durées, vos données sont supprimées définitivement ou anonymisées de manière irréversible.
            </p>
          </div>
        </div>
      </section>

      <!-- Destinataires -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Destinataires des données</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Vos données personnelles sont destinées uniquement aux personnes suivantes :
          </p>

          <ul class="space-y-3 text-slate-600">
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Personnel administratif du club dûment habilité</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Entraîneurs et éducateurs sportifs du club</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Fédération Française de Natation (pour les licences)</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Prestataires techniques (hébergement, paiement) sous contrat strict</span>
            </li>
            <li class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Autorités légales sur demande judiciaire</span>
            </li>
          </ul>

          <div class="bg-orange-500/10 border border-orange-500/20 rounded-lg p-4 mt-6">
            <p class="text-slate-700 text-sm">
              <strong class="text-slate-900">Important :</strong> Nous ne vendons ni ne louons jamais vos données personnelles à des tiers à des fins commerciales.
            </p>
          </div>
        </div>
      </section>

      <!-- Sécurité -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Mesures de sécurité conformes CNIL</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Conformément aux recommandations de la CNIL, nous avons mis en place les mesures suivantes :
          </p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Chiffrement des données</h4>
              <p class="text-slate-600 text-sm">SSL/TLS et AES-256</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Mots de passe sécurisés</h4>
              <p class="text-slate-600 text-sm">Hashage bcrypt, politique stricte</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Sauvegardes régulières</h4>
              <p class="text-slate-600 text-sm">Quotidiennes et chiffrées</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Journalisation</h4>
              <p class="text-slate-600 text-sm">Traçabilité des accès</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Contrôle d'accès</h4>
              <p class="text-slate-600 text-sm">Principe du moindre privilège</p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
              <h4 class="font-semibold text-slate-900 mb-2">Mise à jour régulière</h4>
              <p class="text-slate-600 text-sm">Correctifs de sécurité appliqués</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact DPO -->
      <section class="mb-16">
        <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Délégué à la Protection des Données (DPO)</h2>
          <p class="text-slate-600 mb-6">
            Pour toute question relative à la protection de vos données personnelles ou pour exercer vos droits, vous pouvez contacter notre DPO :
          </p>
          <div class="bg-white/80 rounded-lg p-6">
            <p class="text-slate-900 font-medium mb-2">Délégué à la Protection des Données</p>
            <p class="text-slate-600 text-sm mb-1">Email : <a href="mailto:dpo@lyonpalme.fr" class="text-blue-400 hover:text-blue-300">dpo@lyonpalme.fr</a></p>
            <p class="text-slate-600 text-sm">Courrier : Lyon Palme - DPO, [Adresse complète], 69000 Lyon</p>
          </div>
        </div>
      </section>

      <!-- Réclamation CNIL -->
      <section class="mb-16">
        <div class="bg-orange-500/10 border border-orange-500/20 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Réclamation auprès de la CNIL</h2>
          <p class="text-slate-600 mb-4">
            Si vous estimez que vos droits Informatique et Libertés ne sont pas respectés, vous pouvez adresser une réclamation à la CNIL :
          </p>
          <div class="bg-white/80 rounded-lg p-6">
            <p class="text-slate-900 font-medium mb-3">Commission Nationale de l'Informatique et des Libertés</p>
            <div class="text-slate-600 text-sm space-y-1">
              <p>3 Place de Fontenoy - TSA 80715</p>
              <p>75334 PARIS CEDEX 07</p>
              <p>Tél : 01 53 73 22 22</p>
              <p>Site web : <a href="https://www.cnil.fr" class="text-blue-400 hover:text-blue-300">www.cnil.fr</a></p>
              <p class="mt-3 text-slate-500">Formulaire de plainte en ligne disponible sur le site de la CNIL</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Mise à jour -->
      <section>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6 text-center">
          <p class="text-slate-600 text-sm">
            <strong class="text-slate-900">Dernière mise à jour :</strong> Décembre 2024
          </p>
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
