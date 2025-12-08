@extends('layouts.public')

@section('title', 'Conformité RGPD - Lyon Palme')

@section('content')

  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-white mb-6">Conformité RPGD</h1>
        <p class="text-xl text-slate-300 max-w-3xl mx-auto">
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
            Courrier : Lyon Palme - DPO, 16 Avenue du Docteur Georges Lévy, 69200 Vénissieux
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

@endsection
