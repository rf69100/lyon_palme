@extends('layouts.app')

@section('title', 'Guide de gestion - Lyon Palme')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour au dashboard
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">📚 Guide de gestion</h1>
            <p class="text-slate-600">Documentation complète pour la gestion du club Lyon Palme</p>
        </div>

        <!-- Content -->
        <div class="space-y-6">
            <!-- Section: Adhérents -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">👥 Gestion des adhérents</h2>
                <div class="space-y-4 text-slate-700">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Créer un nouvel adhérent</h3>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>Accédez à la section "Adhérents" depuis le menu principal</li>
                            <li>Cliquez sur le bouton "Nouvel adhérent"</li>
                            <li>Remplissez le formulaire avec les informations personnelles</li>
                            <li>Pour les mineurs, ajoutez les représentants légaux</li>
                            <li>Validez l'inscription</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Modifier un adhérent</h3>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>Recherchez l'adhérent dans la liste</li>
                            <li>Cliquez sur l'icône de modification</li>
                            <li>Modifiez les informations nécessaires</li>
                            <li>Enregistrez les modifications</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Archiver un adhérent</h3>
                        <p class="mb-2">Les adhérents peuvent être archivés lorsqu'ils quittent le club.</p>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>Sélectionnez l'adhérent à archiver</li>
                            <li>Cliquez sur "Archiver"</li>
                            <li>Confirmez l'action</li>
                        </ol>
                        <p class="mt-2 text-sm text-slate-600">⚠️ Note: Les adhérents archivés peuvent être réactivés à tout moment.</p>
                    </div>
                </div>
            </div>

            <!-- Section: Adhésions -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">📝 Gestion des adhésions</h2>
                <div class="space-y-4 text-slate-700">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Créer une adhésion</h3>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>Sélectionnez l'adhérent</li>
                            <li>Choisissez la saison</li>
                            <li>Sélectionnez le type d'adhésion (standard, étudiant, famille, etc.)</li>
                            <li>Choisissez le tarif approprié</li>
                            <li>Validez l'adhésion</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Gérer les paiements</h3>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Suivez les paiements en attente depuis le dashboard</li>
                            <li>Marquez les paiements comme "reçus" une fois validés</li>
                            <li>Générez des reçus pour les adhérents</li>
                            <li>Exportez les données comptables</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Adhésions expirant bientôt</h3>
                        <p class="mb-2">Le système vous alerte automatiquement:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>30 jours avant l'expiration d'une adhésion</li>
                            <li>Visible sur le dashboard secrétaire</li>
                            <li>Contactez les adhérents concernés pour le renouvellement</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section: Activités -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">🎯 Gestion des activités</h2>
                <div class="space-y-4 text-slate-700">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Organiser une sortie</h3>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>Créez une nouvelle sortie avec les détails (date, lieu, niveau requis)</li>
                            <li>Définissez le nombre maximum de participants</li>
                            <li>Ouvrez les inscriptions</li>
                            <li>Gérez les participants inscrits</li>
                            <li>Clôturez la sortie après l'événement</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Gérer une compétition</h3>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>Créez l'événement compétition</li>
                            <li>Indiquez si c'est régional, national ou international</li>
                            <li>Gérez les besoins (hébergement, transport)</li>
                            <li>Suivez les inscriptions</li>
                            <li>Enregistrez les résultats</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Section: Matériel -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">🛠️ Gestion du matériel</h2>
                <div class="space-y-4 text-slate-700">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Inventaire</h3>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Enregistrez tout le matériel du club</li>
                            <li>Suivez l'état de chaque équipement</li>
                            <li>Planifiez les maintenances</li>
                            <li>Gérez les emprunts de matériel</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">Prêts de matériel</h3>
                        <ol class="list-decimal list-inside space-y-2 ml-4">
                            <li>Sélectionnez le matériel à prêter</li>
                            <li>Choisissez l'adhérent emprunteur</li>
                            <li>Définissez la date de retour</li>
                            <li>Enregistrez le prêt</li>
                            <li>Marquez comme "rendu" au retour</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Section: Sécurité -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200 bg-yellow-50 border-yellow-200">
                <h2 class="text-2xl font-bold text-yellow-900 mb-4">🔒 Sécurité et RGPD</h2>
                <div class="space-y-4 text-yellow-900">
                    <div>
                        <h3 class="font-bold text-lg mb-2">Données personnelles</h3>
                        <p class="mb-2">Toutes les données sensibles sont automatiquement chiffrées:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Noms, prénoms, dates de naissance</li>
                            <li>Coordonnées (email, téléphone, adresse)</li>
                            <li>Données médicales (certificats médicaux)</li>
                            <li>Informations des représentants légaux</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg mb-2">Bonnes pratiques</h3>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Ne partagez jamais vos identifiants</li>
                            <li>Déconnectez-vous après chaque session</li>
                            <li>Vérifiez les autorisations avant d'accéder aux données sensibles</li>
                            <li>Signalez toute activité suspecte à l'administrateur</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section: Support -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">💬 Besoin d'aide ?</h2>
                <div class="space-y-4 text-slate-700">
                    <p>Si vous avez des questions ou rencontrez des difficultés:</p>
                    <div class="flex gap-4">
                        <a href="{{ route('help.faq') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                            Consulter la FAQ
                        </a>
                        <a href="{{ route('help.contact') }}" class="inline-flex items-center gap-2 bg-cyan-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-cyan-700 transition">
                            Contacter l'admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
