<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conformité RGPD - Lyon Palme</title>
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
        <div class="inline-block px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full text-green-500 text-sm font-medium mb-6">
          Conforme RGPD
        </div>
        <h1 class="text-5xl font-bold text-slate-900 mb-6">Conformité RGPD</h1>
        <p class="text-xl text-slate-600 max-w-3xl mx-auto">
          Lyon Palme respecte scrupuleusement le Règlement Général sur la Protection des Données
        </p>
      </div>
    </div>
  </div>

  <!-- RGPD Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">
      <!-- Introduction -->
      <section class="mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Notre engagement RGPD</h2>
          <p class="text-slate-600 mb-4">
            Depuis le 25 mai 2018, le Règlement Général sur la Protection des Données (RGPD) encadre le traitement des données personnelles sur le territoire de l'Union Européenne. Lyon Palme s'engage à respecter l'ensemble de ces dispositions pour garantir la protection de vos données.
          </p>
          <p class="text-slate-600">
            Cette page détaille nos pratiques et vos droits en matière de protection des données personnelles.
          </p>
        </div>
      </section>

      <!-- Principes -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Nos principes fondamentaux</h2>
        <div class="space-y-4">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Finalité limitée</h3>
            <p class="text-slate-600">
              Vos données sont collectées pour des finalités déterminées, explicites et légitimes, et ne sont pas traitées ultérieurement de manière incompatible avec ces finalités.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Minimisation des données</h3>
            <p class="text-slate-600">
              Nous ne collectons que les données strictement nécessaires au fonctionnement de notre service. Aucune donnée superflue n'est demandée ou conservée.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Sécurité et confidentialité</h3>
            <p class="text-slate-600">
              Vos données sont protégées par des mesures techniques et organisationnelles appropriées : chiffrement, accès restreints, sauvegardes sécurisées.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Conservation limitée</h3>
            <p class="text-slate-600">
              Les données ne sont conservées que pendant la durée nécessaire aux finalités pour lesquelles elles sont traitées, conformément aux obligations légales.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Exactitude</h3>
            <p class="text-slate-600">
              Nous mettons en œuvre toutes les mesures raisonnables pour garantir que les données inexactes sont effacées ou rectifiées sans délai.
            </p>
          </div>
        </div>
      </section>

      <!-- Données collectées -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Données que nous collectons</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h3 class="text-xl font-bold text-slate-900 mb-4">Données d'identification</h3>
          <ul class="list-disc list-inside text-slate-600 space-y-2 mb-6">
            <li>Nom, prénom</li>
            <li>Date de naissance</li>
            <li>Adresse postale</li>
            <li>Adresse email</li>
            <li>Numéro de téléphone</li>
          </ul>

          <h3 class="text-xl font-bold text-slate-900 mb-4">Données liées à l'activité sportive</h3>
          <ul class="list-disc list-inside text-slate-600 space-y-2 mb-6">
            <li>Certificat médical</li>
            <li>Licence sportive</li>
            <li>Résultats sportifs</li>
            <li>Présences aux entraînements</li>
          </ul>

          <h3 class="text-xl font-bold text-slate-900 mb-4">Données de paiement</h3>
          <ul class="list-disc list-inside text-slate-600 space-y-2">
            <li>Informations de facturation</li>
            <li>Historique des paiements</li>
            <li>Mode de règlement (les coordonnées bancaires sont traitées par notre prestataire de paiement certifié PCI-DSS)</li>
          </ul>
        </div>
      </section>

      <!-- Vos droits -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Vos droits</h2>
        <div class="space-y-4">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Droit d'accès</h3>
            <p class="text-slate-600">
              Vous pouvez obtenir une copie de toutes les données personnelles que nous détenons à votre sujet.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Droit de rectification</h3>
            <p class="text-slate-600">
              Vous pouvez demander la correction de données inexactes ou incomplètes vous concernant.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Droit à l'effacement</h3>
            <p class="text-slate-600">
              Vous pouvez demander la suppression de vos données dans certaines conditions (droit à l'oubli).
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Droit à la portabilité</h3>
            <p class="text-slate-600">
              Vous pouvez recevoir vos données dans un format structuré et couramment utilisé, et les transmettre à un autre responsable de traitement.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Droit d'opposition</h3>
            <p class="text-slate-600">
              Vous pouvez vous opposer au traitement de vos données personnelles pour des raisons tenant à votre situation particulière.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Droit à la limitation</h3>
            <p class="text-slate-600">
              Vous pouvez demander la limitation du traitement de vos données dans certaines circonstances.
            </p>
          </div>
        </div>

        <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-6 mt-6">
          <p class="text-slate-700 mb-4">
            <strong class="text-slate-900">Pour exercer vos droits :</strong>
          </p>
          <p class="text-slate-600 mb-2">
            Contactez notre Délégué à la Protection des Données (DPO) :
          </p>
          <p class="text-blue-400">
            Email : dpo@lyonpalme.fr<br>
            Courrier : Lyon Palme - DPO, [Adresse], 69000 Lyon
          </p>
        </div>
      </section>

      <!-- Sécurité -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Mesures de sécurité</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-3">Chiffrement</h3>
              <p class="text-slate-600 text-sm">
                Toutes les données sensibles sont chiffrées en transit (SSL/TLS) et au repos (AES-256).
              </p>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-3">Authentification</h3>
              <p class="text-slate-600 text-sm">
                Authentification forte et gestion stricte des accès avec politique de mots de passe robustes.
              </p>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-3">Sauvegardes</h3>
              <p class="text-slate-600 text-sm">
                Sauvegardes automatiques quotidiennes chiffrées et stockées en lieu sûr.
              </p>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900 mb-3">Accès restreints</h3>
              <p class="text-slate-600 text-sm">
                Seules les personnes autorisées ont accès aux données, selon le principe du moindre privilège.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Sous-traitants -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Nos sous-traitants</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Nous travaillons avec des sous-traitants certifiés qui respectent les exigences du RGPD :
          </p>
          <ul class="list-disc list-inside text-slate-600 space-y-2">
            <li>Hébergement : serveurs situés en France, conformes HDS (Hébergeur de Données de Santé)</li>
            <li>Paiement : prestataire certifié PCI-DSS</li>
            <li>Emails : infrastructure européenne conforme RGPD</li>
          </ul>
          <p class="text-slate-600 mt-6">
            Tous nos sous-traitants sont liés par des contrats de sous-traitance conformes à l'article 28 du RGPD.
          </p>
        </div>
      </section>

      <!-- Réclamation -->
      <section class="mb-16">
        <div class="bg-gradient-to-r from-orange-500/10 to-red-500/10 border border-orange-500/20 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Droit de réclamation</h2>
          <p class="text-slate-600 mb-4">
            Si vous estimez que vos droits ne sont pas respectés, vous avez le droit d'introduire une réclamation auprès de la CNIL :
          </p>
          <div class="text-slate-700">
            <p class="mb-2"><strong class="text-slate-900">Commission Nationale de l'Informatique et des Libertés (CNIL)</strong></p>
            <p class="text-sm text-slate-600">
              3 Place de Fontenoy - TSA 80715<br>
              75334 PARIS CEDEX 07<br>
              Tél : 01 53 73 22 22<br>
              <a href="https://www.cnil.fr" class="text-blue-400 hover:text-blue-300">www.cnil.fr</a>
            </p>
          </div>
        </div>
      </section>

      <!-- Mise à jour -->
      <section>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6 text-center">
          <p class="text-slate-600 text-sm">
            <strong class="text-slate-900">Dernière mise à jour :</strong> Décembre 2024
          </p>
          <p class="text-slate-500 text-sm mt-2">
            Nous nous réservons le droit de modifier cette politique. Les modifications seront publiées sur cette page.
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
