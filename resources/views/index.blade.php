<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lyon Palme - Gestion de Club</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>🏊 Lyon Palme</h1>
            <p class="subtitle">Système de Gestion de Club de Plongée & Nage avec Palmes</p>
        </header>

        <!-- À propos -->
        <div class="section">
            <h2>📋 À Propos du Projet</h2>
            <p style="line-height: 1.8; margin-top: 1rem;">
                <strong>Lyon Palme</strong> est une application web complète de gestion pour un club de plongée et nage avec palmes basé à Lyon.
                Cette application permet de gérer tous les aspects administratifs, sportifs et logistiques d'un club aquatique.
            </p>

            <div class="info-box">
                <strong>🎯 Objectif Principal :</strong> Centraliser et automatiser la gestion d'un club sportif aquatique,
                de l'adhésion des membres jusqu'à l'organisation des compétitions et sorties.
            </div>
        </div>

        <!-- Fonctionnalités -->
        <div class="section">
            <h2>⚡ Fonctionnalités Principales</h2>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <div class="feature-title">Gestion des Adhérents</div>
                    <div class="feature-desc">
                        Profils complets avec distinction mineurs/adultes, représentants légaux,
                        coordonnées chiffrées (RGPD), photos et notes.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <div class="feature-title">Gestion des Adhésions</div>
                    <div class="feature-desc">
                        Types d'adhésion multiples (Adulte, Jeune, Étudiant), tarification par saison,
                        suivi des paiements échelonnés, calcul automatique des soldes.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🏥</div>
                    <div class="feature-title">Suivi Médical</div>
                    <div class="feature-desc">
                        Certificats médicaux avec alertes de validité, gestion des aptitudes,
                        conformité réglementaire pour la pratique sportive.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎖️</div>
                    <div class="feature-title">Certifications FFESSM</div>
                    <div class="feature-desc">
                        Niveaux de plongée (N1-N5, PE-12 à PE-60), apnée (A1-A4),
                        nage avec palmes (NP1-NP4), moniteurs (E1-E4, MF1-MF2).
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🏋️</div>
                    <div class="feature-title">Entraînements</div>
                    <div class="feature-desc">
                        Planification des séances, programmes personnalisés,
                        affectation des entraîneurs, suivi de la présence.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <div class="feature-title">Compétitions</div>
                    <div class="feature-desc">
                        Organisation complète : modalités, inscriptions, résultats,
                        classements par catégorie d'âge et discipline.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🚤</div>
                    <div class="feature-title">Sorties Club</div>
                    <div class="feature-desc">
                        Planification de sorties (Marseille, Annecy, Port-Cros),
                        inscriptions, coûts, niveau requis, places limitées.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🤿</div>
                    <div class="feature-title">Matériel</div>
                    <div class="feature-desc">
                        Inventaire complet (palmes, masques, tubas, combinaisons),
                        prêts aux membres, suivi d'état, maintenance.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📄</div>
                    <div class="feature-title">Documents</div>
                    <div class="feature-desc">
                        Stockage sécurisé des documents administratifs,
                        justificatifs, licences, assurances.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <div class="feature-title">RGPD & Sécurité</div>
                    <div class="feature-desc">
                        Champs sensibles chiffrés, consentements trackés,
                        journaux de connexion, réinitialisation sécurisée.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👔</div>
                    <div class="feature-title">Rôles & Permissions</div>
                    <div class="feature-div">
                        11 rôles (Président, Secrétaire, Trésorier, Moniteur, etc.),
                        annuaire du bureau avec contacts.
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <div class="feature-title">Statistiques</div>
                    <div class="feature-desc">
                        Vue consolidée des adhésions (validée, expirée, en attente),
                        rapports financiers, taux de présence.
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="section" style="text-align: center;">
            <h2>🎉 Prêt à Commencer ?</h2>
            <p style="margin: 1.5rem 0; font-size: 1.1rem;">
                La base de données est prête avec 100 adhérents, 163 certifications, 25 sorties et bien plus !
            </p>
            <a href="/dashboard" class="cta-button">Accéder au Dashboard</a>

            <p style="margin-top: 2rem; color: #999; font-size: 0.9rem;">
                Développé avec ❤️ pour Lyon Palme - Laravel 12 & MariaDB
            </p>
        </div>
    </div>
</body>
</html>
