<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Politique de Confidentialité - Lyon Palme</title>
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center gap-3">
          <a href="/" class="font-bold text-xl text-slate-900">Lyon Palme</a>
        </div>
        <div class="flex gap-3">
          <a href="/login" class="px-6 py-2 text-slate-700 hover:text-slate-900 font-medium">
            Connexion
          </a>
          <a href="/register" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
            S'inscrire
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
      <h1 class="text-4xl font-bold text-slate-900 mb-8">Politique de Confidentialité</h1>
      
      <div class="prose prose-sm max-w-none text-slate-700 space-y-6">
        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">1. Introduction</h2>
          <p>
            Lyon Palme (« nous », « le Système ») s'engage à protéger votre vie privée. Cette Politique de Confidentialité explique comment nous collectons, utilisons et protégeons vos données personnelles conformément au Règlement Général sur la Protection des Données (RGPD) et à la Loi Informatique et Libertés française.
          </p>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">2. Données Collectées</h2>
          <p>Nous collectons les catégories de données suivantes :</p>
          <ul class="list-disc pl-6 space-y-2">
            <li><strong>Informations personnelles :</strong> Nom, prénom, adresse e-mail, téléphone, date de naissance, adresse postale</li>
            <li><strong>Données sensibles :</strong> Informations médicales (certificats, aptitudes), photos</li>
            <li><strong>Données financières :</strong> Informations d'adhésion, historique des paiements</li>
            <li><strong>Données de navigation :</strong> Adresse IP, logs de connexion, activités sur la plateforme</li>
            <li><strong>Représentants légaux :</strong> Pour les mineurs, données des responsables légaux</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">3. Base Légale du Traitement</h2>
          <p>Le traitement de vos données repose sur :</p>
          <ul class="list-disc pl-6 space-y-2">
            <li>Votre consentement explicite (pour les données sensibles)</li>
            <li>L'exécution du contrat d'adhésion</li>
            <li>Le respect d'obligations légales</li>
            <li>Nos intérêts légitimes (sécurité, fraude)</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">4. Utilisation des Données</h2>
          <p>Vos données sont utilisées pour :</p>
          <ul class="list-disc pl-6 space-y-2">
            <li>Gérer votre adhésion et vos accès à la plateforme</li>
            <li>Vous permettre de participer aux activités du club (entraînements, compétitions, sorties)</li>
            <li>Gérer les aspects administratifs et financiers</li>
            <li>Assurer la sécurité et la conformité réglementaire</li>
            <li>Communiquer avec vous concernant le club</li>
            <li>Vous envoyer des informations relatives à la pratique sportive</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">5. Sécurité des Données</h2>
          <p>
            Nous mettons en place des mesures de sécurité robustes pour protéger vos données :
          </p>
          <ul class="list-disc pl-6 space-y-2">
            <li><strong>Chiffrement :</strong> Les champs sensibles (coordonnées, données médicales) sont chiffrés en base de données</li>
            <li><strong>Contrôle d'accès :</strong> Seuls les utilisateurs autorisés peuvent accéder aux données sensibles</li>
            <li><strong>Journalisation :</strong> Tous les accès aux données sensibles sont enregistrés</li>
            <li><strong>Infrastructure sécurisée :</strong> Serveurs protégés, pare-feu, certificats SSL/TLS</li>
            <li><strong>Audit régulier :</strong> Vérifications de conformité et tests de sécurité</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">6. Partage des Données</h2>
          <p>
            Vos données ne sont pas vendues. Elles peuvent être partagées avec :
          </p>
          <ul class="list-disc pl-6 space-y-2">
            <li>Les membres du bureau du club (directeur, trésorier, etc.) pour l'administration</li>
            <li>Les entraîneurs pour la gestion des entraînements</li>
            <li>Les autorités légales si requis par la loi</li>
            <li>Les prestataires techniques (hébergement, maintenance) sous contrats de confidentialité</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">7. Durée de Conservation</h2>
          <p>
            Les données sont conservées tant que nécessaire pour les finalités déclarées :
          </p>
          <ul class="list-disc pl-6 space-y-2">
            <li>Données d'adhérents actifs : pendant la durée d'adhésion + 3 ans (obligations légales)</li>
            <li>Données de paiement : 6 ans (délai de prescription)</li>
            <li>Logs de connexion : 6 mois</li>
            <li>Données de mineurs : supprimées à la majorité sauf consentement contraire</li>
          </ul>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">8. Vos Droits</h2>
          <p>Conformément au RGPD, vous avez le droit de :</p>
          <ul class="list-disc pl-6 space-y-2">
            <li><strong>Droit d'accès :</strong> Obtenir une copie de vos données</li>
            <li><strong>Droit de rectification :</strong> Corriger les données inexactes</li>
            <li><strong>Droit à l'oubli :</strong> Demander la suppression de vos données</li>
            <li><strong>Droit à la limitation :</strong> Demander la limitation du traitement</li>
            <li><strong>Droit à la portabilité :</strong> Récupérer vos données dans un format structuré</li>
            <li><strong>Droit d'opposition :</strong> Vous opposer au traitement de vos données</li>
            <li><strong>Droits liés au profilage :</strong> Vous opposer à la prise de décision automatisée</li>
          </ul>
          <p class="mt-4">
            Pour exercer ces droits, contactez-nous à l'adresse mentionnée à la fin de cette politique.
          </p>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">9. Consentements</h2>
          <p>
            Pour certains traitements de données sensibles (photos, données médicales), nous vous demandons un consentement explicite. Vous pouvez retirer votre consentement à tout moment sans justification.
          </p>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">10. Modifications de Cette Politique</h2>
          <p>
            Nous pouvons mettre à jour cette Politique de Confidentialité à tout moment. Les modifications seront publiées sur cette page avec la date de la dernière mise à jour.
          </p>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">11. Contactez-Nous</h2>
          <p>
            Pour toute question concernant cette Politique de Confidentialité ou l'exercice de vos droits RGPD :
          </p>
          <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mt-4">
            <p><strong>Lyon Palme</strong></p>
            <p>E-mail : contact@lyonpalme.fr</p>
            <p>Adresse : [À remplir avec vos coordonnées]</p>
          </div>
        </section>

        <section>
          <h2 class="text-2xl font-bold text-slate-900 mt-8 mb-4">12. Autorité Compétente</h2>
          <p>
            Si vous estimez que nous ne respectons pas votre vie privée, vous pouvez déposer plainte auprès de :
          </p>
          <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mt-4">
            <p><strong>CNIL (Commission Nationale de l'Informatique et des Libertés)</strong></p>
            <p>3 Place de Fontenoy, 75007 Paris</p>
            <p>Tél. : 01 53 73 22 22</p>
            <p>Site : www.cnil.fr</p>
          </div>
        </section>

        <p class="text-slate-500 text-sm mt-12">
          Dernière mise à jour : Décembre 2024
        </p>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div>
          <h3 class="font-bold text-white mb-4">Lyon Palme</h3>
          <p class="text-sm text-slate-400">
            Club de palmage et plongée - FFESSM AURA<br>
            Centre Nautique de Saint-Fons<br>
            20 Rue des Frères Lumière, 69190 Saint-Fons
          </p>
        </div>
        <div>
          <h4 class="font-bold text-white mb-4">Produit</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="/#features" class="hover:text-white">Fonctionnalités</a></li>
            <li><a href="/documentation" class="hover:text-white">Documentation</a></li>
            <li><a href="/support" class="hover:text-white">Support</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-white mb-4">Sécurité</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="/rgpd" class="hover:text-white">Conformité RGPD</a></li>
            <li><a href="/cnil-policy" class="hover:text-white">Politique CNIL</a></li>
            <li><a href="/encryption" class="hover:text-white">Chiffrement E2E</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-white mb-4">Légal</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="/privacy-policy" class="hover:text-white">Politique de confidentialité</a></li>
            <li><a href="/terms" class="hover:text-white">Conditions d'utilisation</a></li>
            <li><a href="/cookies" class="hover:text-white">Politique de cookies</a></li>
          </ul>
        </div>
      </div>
      <div class="border-t border-slate-800 pt-8">
        <div class="flex flex-col sm:flex-row justify-between items-center">
          <p class="text-sm text-slate-400">
            © 2024 Lyon Palme. Tous droits réservés.
          </p>
          <p class="text-sm text-slate-400 mt-4 sm:mt-0">
            Développé avec Laravel 12 & MariaDB
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
