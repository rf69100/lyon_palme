@extends('layouts.app')

@section('title', 'FAQ Secrétaire - Lyon Palme')

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
            <h1 class="text-4xl font-bold text-slate-900 mb-2">❓ FAQ Secrétaire</h1>
            <p class="text-slate-600">Questions fréquemment posées et leurs réponses</p>
        </div>

        <!-- Search Box -->
        <div class="mb-8">
            <div class="relative">
                <input
                    type="text"
                    id="faq-search"
                    placeholder="Rechercher dans la FAQ..."
                    class="w-full px-4 py-3 pl-12 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                />
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- FAQ Content -->
        <div class="space-y-4" id="faq-content">
            <!-- Adhérents -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Comment créer un nouvel adhérent ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700">Accédez au menu "Adhérents" puis cliquez sur "Nouvel adhérent". Remplissez le formulaire avec les informations personnelles de l'adhérent. Pour les mineurs, vous devrez également ajouter au moins un représentant légal avec ses coordonnées complètes.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Que faire quand un adhérent quitte le club ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700">Ne supprimez jamais un adhérent ! Utilisez la fonction "Archiver" depuis la fiche de l'adhérent. Cela préserve l'historique tout en le retirant de la liste active. L'adhérent peut être réactivé à tout moment si nécessaire.</p>
                </div>
            </div>

            <!-- Adhésions -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Comment gérer le renouvellement des adhésions ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700 mb-3">Le dashboard affiche automatiquement les adhésions expirant dans les 30 prochains jours. Pour renouveler:</p>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 ml-4">
                        <li>Contactez l'adhérent concerné</li>
                        <li>Créez une nouvelle adhésion pour la nouvelle saison</li>
                        <li>Sélectionnez le type et tarif appropriés</li>
                        <li>Enregistrez le paiement une fois reçu</li>
                    </ol>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Quels sont les différents types d'adhésion ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700 mb-3">Le club propose plusieurs types d'adhésion:</p>
                    <ul class="list-disc list-inside space-y-2 text-slate-700 ml-4">
                        <li><strong>Standard:</strong> Adhésion classique pour adultes</li>
                        <li><strong>Étudiant:</strong> Tarif réduit pour les étudiants (justificatif requis)</li>
                        <li><strong>Famille:</strong> Tarif préférentiel pour les familles (2+ membres)</li>
                        <li><strong>Découverte:</strong> Adhésion courte durée pour essayer le club</li>
                    </ul>
                </div>
            </div>

            <!-- Paiements -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Comment enregistrer un paiement ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700 mb-3">Pour enregistrer un paiement:</p>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 ml-4">
                        <li>Accédez à la fiche de l'adhésion concernée</li>
                        <li>Cliquez sur "Enregistrer un paiement"</li>
                        <li>Sélectionnez le mode de paiement (espèces, chèque, virement)</li>
                        <li>Indiquez le montant reçu</li>
                        <li>Générez un reçu si nécessaire</li>
                    </ol>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Que faire en cas d'impayé ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700 mb-3">Procédure pour les impayés:</p>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 ml-4">
                        <li>Envoyez un rappel à l'adhérent après 15 jours</li>
                        <li>Si pas de réponse, envoyez un second rappel après 30 jours</li>
                        <li>Contactez le bureau du club si l'impayé persiste au-delà de 45 jours</li>
                        <li>Le statut de l'adhésion passera automatiquement à "en attente" après 60 jours</li>
                    </ol>
                </div>
            </div>

            <!-- Activités -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Comment organiser une sortie club ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700 mb-3">Pour créer une sortie:</p>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 ml-4">
                        <li>Accédez au menu "Sorties" et cliquez sur "Nouvelle sortie"</li>
                        <li>Remplissez les détails: date, lieu, niveau requis, nombre max de participants</li>
                        <li>Définissez les responsables et encadrants</li>
                        <li>Ouvrez les inscriptions aux adhérents</li>
                        <li>Gérez les inscriptions et la liste d'attente si nécessaire</li>
                    </ol>
                </div>
            </div>

            <!-- Matériel -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-slate-50 transition faq-question">
                    <h3 class="text-lg font-bold text-slate-900">Comment gérer les prêts de matériel ?</h3>
                    <svg class="w-6 h-6 text-slate-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-slate-700 mb-3">Gérez les prêts depuis le menu "Matériel":</p>
                    <ul class="list-disc list-inside space-y-2 text-slate-700 ml-4">
                        <li>Vérifiez la disponibilité du matériel</li>
                        <li>Créez un prêt en sélectionnant l'équipement et l'emprunteur</li>
                        <li>Définissez la date de retour prévue</li>
                        <li>Le système vous alertera automatiquement des retours en retard</li>
                        <li>Marquez comme "rendu" lors du retour et vérifiez l'état du matériel</li>
                    </ul>
                </div>
            </div>

            <!-- Sécurité -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden bg-yellow-50 border-yellow-200">
                <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-yellow-100 transition faq-question">
                    <h3 class="text-lg font-bold text-yellow-900">Comment sont protégées les données personnelles ?</h3>
                    <svg class="w-6 h-6 text-yellow-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="px-8 pb-6 hidden faq-answer">
                    <p class="text-yellow-900 mb-3">Le système Lyon Palme est conforme au RGPD:</p>
                    <ul class="list-disc list-inside space-y-2 text-yellow-900 ml-4">
                        <li>Toutes les données sensibles sont chiffrées en base de données</li>
                        <li>Chaque action sur les données est enregistrée dans les logs d'audit</li>
                        <li>Les mots de passe sont hashés avec des algorithmes sécurisés</li>
                        <li>L'accès aux données est limité selon les rôles</li>
                        <li>Les certificats médicaux sont particulièrement protégés (données de santé)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-8 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Vous ne trouvez pas votre réponse ?</h2>
            <p class="text-slate-700 mb-4">N'hésitez pas à contacter l'administrateur pour obtenir de l'aide.</p>
            <a href="{{ route('help.contact') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                Contacter l'admin
            </a>
        </div>
    </div>
</div>

<script>
// FAQ Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.faq-question');

    questions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('svg');

            // Toggle answer visibility
            answer.classList.toggle('hidden');

            // Rotate icon
            icon.classList.toggle('rotate-180');
        });
    });

    // Search functionality
    const searchInput = document.getElementById('faq-search');
    const faqItems = document.querySelectorAll('#faq-content > div');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer p, .faq-answer ul, .faq-answer ol');
            const answerText = answer ? answer.textContent.toLowerCase() : '';

            if (question.includes(searchTerm) || answerText.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
