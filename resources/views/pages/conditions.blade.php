@extends('layouts.public')

@section('title', 'Conditions d\'utilisation - Lyon Palme')

@section('content')

  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-white mb-6">Conditions Générales d'Utilisation</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto">
          Règles d'utilisation de la plateforme Lyon Palme
        </p>
        <p class="text-sm text-slate-300 mt-4">Dernière mise à jour : Décembre 2024</p>
      </div>
    </div>
  </div>

  <!-- Terms Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">
      <!-- Introduction -->
      <section class="mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">1. Objet</h2>
          <p class="text-slate-600 mb-4">
            Les présentes Conditions Générales d'Utilisation (CGU) ont pour objet de définir les modalités et conditions d'utilisation de la plateforme Lyon Palme, ainsi que les droits et obligations des utilisateurs.
          </p>
          <p class="text-slate-600 mb-4">
            Lyon Palme est une plateforme de gestion complète pour clubs aquatiques permettant la gestion des adhésions, des entraînements, des compétitions et de la comptabilité.
          </p>
          <p class="text-slate-600">
            En accédant et en utilisant la plateforme Lyon Palme, vous acceptez sans réserve les présentes CGU.
          </p>
        </div>
      </section>

      <!-- Définitions -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">2. Définitions</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <div class="space-y-4">
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Plateforme</h3>
              <p class="text-slate-600 text-sm">
                Désigne le service Lyon Palme accessible via l'adresse web et ses applications mobiles.
              </p>
            </div>
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Utilisateur</h3>
              <p class="text-slate-600 text-sm">
                Toute personne physique ou morale utilisant la plateforme (membre, administrateur, entraîneur).
              </p>
            </div>
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Club</h3>
              <p class="text-slate-600 text-sm">
                Structure sportive cliente utilisant la plateforme pour gérer ses activités.
              </p>
            </div>
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Compte</h3>
              <p class="text-slate-600 text-sm">
                Espace personnel et sécurisé créé pour chaque utilisateur.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Accès à la plateforme -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">3. Accès à la plateforme</h2>
        <div class="space-y-6">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">3.1 Inscription</h3>
            <p class="text-slate-600 mb-3">
              L'accès à certaines fonctionnalités de la plateforme nécessite la création d'un compte. Lors de l'inscription, vous vous engagez à :
            </p>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Fournir des informations exactes, à jour et complètes</li>
              <li>Mettre à jour ces informations pour les maintenir exactes</li>
              <li>Être âgé d'au moins 16 ans ou avoir l'autorisation parentale</li>
              <li>Ne créer qu'un seul compte par personne</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">3.2 Identifiants</h3>
            <p class="text-slate-600 mb-3">
              Vous êtes responsable de la confidentialité de vos identifiants de connexion. Vous vous engagez à :
            </p>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Choisir un mot de passe robuste</li>
              <li>Ne pas partager vos identifiants avec des tiers</li>
              <li>Nous informer immédiatement de toute utilisation non autorisée</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">3.3 Disponibilité</h3>
            <p class="text-slate-600">
              Nous mettons tout en œuvre pour assurer la disponibilité de la plateforme 24h/24 et 7j/7. Toutefois, des interruptions peuvent survenir pour maintenance, mises à jour ou cas de force majeure.
            </p>
          </div>
        </div>
      </section>

      <!-- Utilisation -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">4. Utilisation de la plateforme</h2>
        <div class="space-y-6">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">4.1 Usage autorisé</h3>
            <p class="text-slate-600 mb-3">
              Vous vous engagez à utiliser la plateforme uniquement pour :
            </p>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>La gestion des activités de votre club aquatique</li>
              <li>Des finalités légales et conformes aux bonnes mœurs</li>
              <li>Le respect des droits des autres utilisateurs</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">4.2 Usages interdits</h3>
            <p class="text-slate-600 mb-3">
              Il est strictement interdit de :
            </p>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Tenter d'accéder aux comptes d'autres utilisateurs</li>
              <li>Utiliser des robots, scripts ou moyens automatisés non autorisés</li>
              <li>Interférer avec le fonctionnement de la plateforme</li>
              <li>Copier, modifier ou distribuer le contenu sans autorisation</li>
              <li>Utiliser la plateforme à des fins commerciales non autorisées</li>
              <li>Télécharger des virus ou codes malveillants</li>
              <li>Usurper l'identité d'une autre personne</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Propriété intellectuelle -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">5. Propriété intellectuelle</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-4">
            Tous les éléments de la plateforme Lyon Palme (textes, graphiques, logiciels, bases de données, sons, vidéos, marques, logos) sont protégés par le droit d'auteur, le droit des marques et autres droits de propriété intellectuelle.
          </p>
          <p class="text-slate-600 mb-4">
            L'utilisation de la plateforme ne vous confère aucun droit de propriété intellectuelle sur ces éléments. Toute reproduction, représentation, modification ou exploitation non autorisée est interdite.
          </p>
          <p class="text-slate-600">
            Les données que vous saisissez sur la plateforme vous appartiennent. Vous nous accordez une licence limitée pour traiter ces données dans le cadre de la fourniture du service.
          </p>
        </div>
      </section>

      <!-- Responsabilité -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">6. Responsabilité</h2>
        <div class="space-y-6">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">6.1 Responsabilité de Lyon Palme</h3>
            <p class="text-slate-600 mb-3">
              Lyon Palme s'engage à fournir un service de qualité et à mettre en œuvre tous les moyens nécessaires pour assurer la sécurité et la disponibilité de la plateforme.
            </p>
            <p class="text-slate-600">
              Toutefois, notre responsabilité ne saurait être engagée en cas de force majeure, de fait imprévisible et insurmontable d'un tiers, ou en cas de faute de l'utilisateur.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">6.2 Responsabilité de l'utilisateur</h3>
            <p class="text-slate-600 mb-3">
              Vous êtes seul responsable :
            </p>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>De l'utilisation que vous faites de la plateforme</li>
              <li>Des données que vous saisissez et diffusez</li>
              <li>De la préservation de la confidentialité de vos identifiants</li>
              <li>Des conséquences d'une utilisation frauduleuse de votre compte</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">6.3 Limitation de responsabilité</h3>
            <p class="text-slate-600">
              En tout état de cause, la responsabilité de Lyon Palme est limitée au montant des sommes versées par le club au cours des 12 derniers mois précédant le fait générateur de responsabilité.
            </p>
          </div>
        </div>
      </section>

      <!-- Données personnelles -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">7. Données personnelles</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-4">
            Nous attachons une grande importance à la protection de vos données personnelles. Leur collecte, traitement et utilisation sont régis par notre Politique de Confidentialité.
          </p>
          <p class="text-slate-600 mb-6">
            En utilisant la plateforme, vous acceptez notre Politique de Confidentialité et le traitement de vos données personnelles conformément à celle-ci.
          </p>
          <a href="/confidentialite" class="px-6 py-4 flex items-center justify-center bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium">
            Consulter la Politique de Confidentialité
          </a>
        </div>
      </section>

      <!-- Résiliation -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">8. Résiliation</h2>
        <div class="space-y-6">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">8.1 Résiliation par l'utilisateur</h3>
            <p class="text-slate-600">
              Vous pouvez résilier votre compte à tout moment depuis les paramètres de votre compte ou en contactant notre support. La résiliation prend effet immédiatement.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">8.2 Résiliation par Lyon Palme</h3>
            <p class="text-slate-600 mb-3">
              Nous nous réservons le droit de suspendre ou résilier votre compte en cas de :
            </p>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Violation des présentes CGU</li>
              <li>Utilisation frauduleuse de la plateforme</li>
              <li>Impayés</li>
              <li>Inactivité prolongée (plus de 24 mois)</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">8.3 Conséquences de la résiliation</h3>
            <p class="text-slate-600">
              En cas de résiliation, vous perdez l'accès à votre compte et à toutes les données associées. Nous conservons vos données pendant la durée légale puis les supprimons définitivement.
            </p>
          </div>
        </div>
      </section>

      <!-- Modifications -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">9. Modifications des CGU</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-4">
            Nous nous réservons le droit de modifier les présentes CGU à tout moment. Les modifications sont effectives dès leur publication sur la plateforme.
          </p>
          <p class="text-slate-600 mb-4">
            En cas de modification substantielle, nous vous en informerons par email ou via une notification sur la plateforme au moins 30 jours avant leur entrée en vigueur.
          </p>
          <p class="text-slate-600">
            L'utilisation continue de la plateforme après modification des CGU vaut acceptation des nouvelles conditions.
          </p>
        </div>
      </section>

      <!-- Droit applicable -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">10. Droit applicable et litiges</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <div class="space-y-4">
            <div>
              <h3 class="font-semibold text-slate-900 mb-2">10.1 Droit applicable</h3>
              <p class="text-slate-600">
                Les présentes CGU sont régies par le droit français.
              </p>
            </div>

            <div>
              <h3 class="font-semibold text-slate-900 mb-2">10.2 Résolution amiable</h3>
              <p class="text-slate-600">
                En cas de différend, nous vous invitons à nous contacter pour tenter de trouver une solution amiable.
              </p>
            </div>

            <div>
              <h3 class="font-semibold text-slate-900 mb-2">10.3 Médiation</h3>
              <p class="text-slate-600 mb-2">
                Conformément à l'article L.612-1 du Code de la consommation, vous pouvez recourir gratuitement à un médiateur de la consommation en cas de litige :
              </p>
            </div>

            <div>
              <h3 class="font-semibold text-slate-900 mb-2">10.4 Juridiction compétente</h3>
              <p class="text-slate-600">
                À défaut de résolution amiable, tout litige relève de la compétence exclusive des tribunaux français.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">11. Contact</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-4">
            Pour toute question concernant ces Conditions Générales d'Utilisation, vous pouvez nous contacter :
          </p>
          <div class="space-y-2 text-slate-700">
            <p>Email : <a href="mailto:contact@lyonpalme.fr" class="text-blue-400 hover:text-blue-300">contact@lyonpalme.fr</a></p>
            <p>Support : <a href="/support" class="text-blue-400 hover:text-blue-300">Page de support</a></p>
            <p>Adresse : Lyon Palme, 16 Avenue du Docteur Georges Lévy, 69200 Vénissieux</p>
          </div>
        </div>
      </section>

      <!-- Acceptation -->
      <section>
        <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-8 text-center">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Acceptation des CGU</h2>
          <p class="text-slate-600 mb-2">
            En utilisant la plateforme Lyon Palme, vous reconnaissez avoir lu, compris et accepté l'intégralité des présentes Conditions Générales d'Utilisation.
          </p>
          <p class="text-slate-500 text-sm mt-4">
            Version du : Décembre 2024
          </p>
        </div>
      </section>
    </div>
  </div>

@endsection
