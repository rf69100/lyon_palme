@extends('layouts.public')

@section('title', 'Politique de confidentialité - Lyon Palme')

@section('content')

  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-white mb-6">Politique de confidentialité</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto">
          Comment nous collectons, utilisons et protégeons vos données personnelles
        </p>
        <p class="text-sm text-slate-300 mt-4">Dernière mise à jour : Décembre 2024</p>
      </div>
    </div>
  </div>

  <!-- Privacy Content -->
  <div class="container mx-auto px-6 py-16">
    <div class="max-w-4xl mx-auto">
      <!-- Introduction -->
      <section class="mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Introduction</h2>
          <p class="text-slate-600 mb-4">
            La présente politique de confidentialité décrit la façon dont Lyon Palme collecte, utilise, partage et protège vos données personnelles lorsque vous utilisez notre plateforme de gestion pour clubs aquatiques.
          </p>
          <p class="text-slate-600 mb-4">
            Lyon Palme s'engage à protéger votre vie privée et à traiter vos données personnelles de manière transparente et conforme au Règlement Général sur la Protection des Données (RGPD) et à la loi Informatique et Libertés.
          </p>
          <p class="text-slate-600">
            En utilisant nos services, vous acceptez les pratiques décrites dans cette politique.
          </p>
        </div>
      </section>

      <!-- Responsable de traitement -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Responsable du traitement</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <div class="space-y-4">
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Raison sociale</h3>
              <p class="text-slate-600">Lyon Palme</p>
            </div>
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Adresse</h3>
              <p class="text-slate-600">16 Avenue du Docteur Georges Lévy,<br>69200 Vénissieux,<br>France</p>
            </div>
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Contact</h3>
              <p class="text-slate-600">Email : contact@lyonpalme.fr</p>
            </div>
            <div>
              <h3 class="font-semibold text-slate-900 mb-1">Délégué à la Protection des Données (DPO)</h3>
              <p class="text-slate-600">Email : dpo@lyonpalme.fr</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Données collectées -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Données que nous collectons</h2>

        <div class="space-y-6">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">1. Données d'identification</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Nom, prénom</li>
              <li>Date et lieu de naissance</li>
              <li>Adresse postale</li>
              <li>Numéro de téléphone</li>
              <li>Adresse email</li>
              <li>Photo (facultatif)</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">2. Données de connexion</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Identifiant et mot de passe (chiffré)</li>
              <li>Adresse IP</li>
              <li>Logs de connexion et d'activité</li>
              <li>Type de navigateur et appareil</li>
              <li>Cookies techniques</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">3. Données liées à l'activité sportive</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Numéro de licence FFN</li>
              <li>Certificat médical</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">4. Données financières</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Informations de facturation</li>
              <li>Historique des paiements et cotisations</li>
              <li>Mode de règlement</li>
            </ul>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">5. Données de communication</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
              <li>Échanges avec le support</li>
              <li>Messages internes au club</li>
              <li>Historique des communications</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Utilisation -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Comment utilisons-nous vos données ?</h2>
        <div class="space-y-4">
          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Gestion de votre adhésion</h3>
            <p class="text-slate-600 text-sm">
              Création et mise à jour de votre fiche membre, gestion de votre licence sportive, renouvellement de votre certificat médical.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Organisation des activités</h3>
            <p class="text-slate-600 text-sm">
              Attribution à un groupe, planification des entraînements, suivi de vos présences, inscription aux compétitions.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Gestion financière</h3>
            <p class="text-slate-600 text-sm">
              Facturation, encaissement des cotisations, suivi des paiements, relances en cas d'impayé.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Communication</h3>
            <p class="text-slate-600 text-sm">
              Envoi d'informations relatives à la vie du club, convocations aux compétitions, résultats sportifs, actualités.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Amélioration du service</h3>
            <p class="text-slate-600 text-sm">
              Analyses statistiques anonymisées pour améliorer nos fonctionnalités et l'expérience utilisateur.
            </p>
          </div>

          <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Sécurité</h3>
            <p class="text-slate-600 text-sm">
              Prévention de la fraude, détection des activités suspectes, respect de nos obligations légales.
            </p>
          </div>
        </div>
      </section>

      <!-- Base légale -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Base légale du traitement</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <div class="space-y-4">
            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Exécution du contrat</p>
                <p class="text-slate-600 text-sm">Nécessaire pour la fourniture de nos services suite à votre adhésion au club</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Obligations légales</p>
                <p class="text-slate-600 text-sm">Respect des obligations comptables, fiscales et réglementaires sportives</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Intérêt légitime</p>
                <p class="text-slate-600 text-sm">Amélioration de nos services, prévention de la fraude, sécurité de la plateforme</p>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
              <div>
                <p class="text-slate-900 font-medium">Consentement</p>
                <p class="text-slate-600 text-sm">Communications marketing, cookies non essentiels, publication de photos</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Partage des données -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Avec qui partageons-nous vos données ?</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Nous ne vendons jamais vos données personnelles. Nous les partageons uniquement dans les cas suivants :
          </p>

          <div class="space-y-4">
            <div>
              <h3 class="font-semibold text-slate-900 mb-2">Au sein de votre club</h3>
              <p class="text-slate-600 text-sm">
                Personnel administratif, entraîneurs et dirigeants autorisés, dans le cadre strict de leurs missions.
              </p>
            </div>

            <div>
              <h3 class="font-semibold text-slate-900 mb-2">Fédération Française de Natation (FFN)</h3>
              <p class="text-slate-600 text-sm">
                Pour l'obtention et le renouvellement de votre licence sportive et l'inscription aux compétitions officielles.
              </p>
            </div>

            <div>
              <h3 class="font-semibold text-slate-900 mb-2">Prestataires de services</h3>
              <p class="text-slate-600 text-sm">
                Hébergeur (serveurs en France), service d'emailing (conforme RGPD).
                Tous nos prestataires sont contractuellement tenus de protéger vos données.
              </p>
            </div>

            <div>
              <h3 class="font-semibold text-slate-900 mb-2">Autorités légales</h3>
              <p class="text-slate-600 text-sm">
                Uniquement sur demande judiciaire ou administrative légalement fondée.
              </p>
            </div>
          </div>

          <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-4 mt-6">
            <p class="text-slate-700 text-sm">
              <strong class="text-slate-900">Important :</strong> Nous ne transférons aucune donnée en dehors de l'Union Européenne.
            </p>
          </div>
        </div>
      </section>

      <!-- Conservation -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Durée de conservation</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Nous conservons vos données personnelles uniquement le temps nécessaire aux finalités poursuivies :
          </p>

          <div class="space-y-3">
            <div class="bg-slate-50 rounded-lg p-4">
              <div class="flex justify-between items-center">
                <span class="text-slate-900">Données d'adhésion active</span>
                <span class="text-blue-400">Durée de l'adhésion</span>
              </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <div class="flex justify-between items-center">
                <span class="text-slate-900">Archives (après résiliation)</span>
                <span class="text-blue-400">3 ans</span>
              </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <div class="flex justify-between items-center">
                <span class="text-slate-900">Données comptables</span>
                <span class="text-blue-400">10 ans (obligation légale)</span>
              </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <div class="flex justify-between items-center">
                <span class="text-slate-900">Logs de connexion</span>
                <span class="text-blue-400">12 mois maximum</span>
              </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <div class="flex justify-between items-center">
                <span class="text-slate-900">Cookies</span>
                <span class="text-blue-400">13 mois maximum</span>
              </div>
            </div>
          </div>

          <p class="text-slate-500 text-sm mt-6">
            Au terme de ces durées, vos données sont supprimées définitivement ou anonymisées de manière irréversible.
          </p>
        </div>
      </section>

      <!-- Droits -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Vos droits</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Conformément au RGPD et à la loi Informatique et Libertés, vous disposez des droits suivants :
          </p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-slate-50 rounded-lg p-4">
              <h3 class="font-semibold text-slate-900 mb-2">Droit d'accès</h3>
              <p class="text-slate-600 text-sm">Obtenir une copie de vos données</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <h3 class="font-semibold text-slate-900 mb-2">Droit de rectification</h3>
              <p class="text-slate-600 text-sm">Corriger vos données inexactes</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <h3 class="font-semibold text-slate-900 mb-2">Droit à l'effacement</h3>
              <p class="text-slate-600 text-sm">Supprimer vos données (droit à l'oubli)</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <h3 class="font-semibold text-slate-900 mb-2">Droit à la portabilité</h3>
              <p class="text-slate-600 text-sm">Récupérer vos données dans un format lisible</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <h3 class="font-semibold text-slate-900 mb-2">Droit d'opposition</h3>
              <p class="text-slate-600 text-sm">Refuser certains traitements</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-4">
              <h3 class="font-semibold text-slate-900 mb-2">Droit à la limitation</h3>
              <p class="text-slate-600 text-sm">Limiter le traitement de vos données</p>
            </div>
          </div>

          <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-6 mt-6">
            <h3 class="font-semibold text-slate-900 mb-3">Comment exercer vos droits ?</h3>
            <p class="text-slate-600 text-sm mb-3">
              Pour exercer vos droits, contactez notre Délégué à la Protection des Données :
            </p>
            <p class="text-blue-400 text-sm">
              Email : dpo@lyonpalme.fr<br>
              Courrier : Lyon Palme - DPO, [Adresse], 69000 Lyon
            </p>
            <p class="text-slate-500 text-sm mt-3">
              Nous vous répondrons dans un délai d'un mois. Une pièce d'identité pourra vous être demandée pour vérifier votre identité.
            </p>
          </div>
        </div>
      </section>

      <!-- Sécurité -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-6">Sécurité de vos données</h2>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <p class="text-slate-600 mb-6">
            Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données :
          </p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600 text-sm">Chiffrement SSL/TLS et AES-256</span>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600 text-sm">Authentification sécurisée</span>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600 text-sm">Sauvegardes quotidiennes chiffrées</span>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600 text-sm">Contrôle d'accès strict</span>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600 text-sm">Surveillance continue</span>
            </div>
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-slate-600 text-sm">Audits de sécurité réguliers</span>
            </div>
          </div>

          <p class="text-slate-500 text-sm mt-6">
            Pour plus de détails, consultez notre <a href="/chiffrement" class="text-blue-400 hover:text-blue-300">page dédiée au chiffrement</a>.
          </p>
        </div>
      </section>

      <!-- Modifications -->
      <section class="mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Modifications de cette politique</h2>
          <p class="text-slate-600 mb-4">
            Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. Toute modification sera publiée sur cette page avec une nouvelle date de mise à jour.
          </p>
          <p class="text-slate-600">
            En cas de modification substantielle, nous vous en informerons par email ou via une notification sur la plateforme.
          </p>
        </div>
      </section>

      <!-- Contact -->
      <section>
        <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">Des questions ?</h2>
          <p class="text-slate-600 mb-6">
            Pour toute question concernant cette politique de confidentialité ou le traitement de vos données personnelles, contactez-nous :
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
