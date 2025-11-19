<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lyon Palme - Gestion de Club</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <!-- <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        header {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 1rem;
        }
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }
        .stat {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }
        .stat-number {
            font-size: 1.8rem;
            display: block;
        }
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 1rem;
            border-bottom: 3px solid #667eea;
            padding-bottom: 0.5rem;
        }
        h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #764ba2;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .feature-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border-left: 4px solid #667eea;
        }
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .feature-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .feature-desc {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        ul {
            list-style: none;
            margin-top: 1rem;
        }
        ul li {
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }
        ul li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: 700;
        }
        .tech-stack {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }
        .tech-badge {
            background: #667eea;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
        .info-box {
            background: #d1ecf1;
            border-left: 4px solid #0dcaf0;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
        .success-box {
            background: #d1e7dd;
            border-left: 4px solid #198754;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
        code {
            background: #f8f9fa;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
        }
    </style> -->
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>🏊 Lyon Palme</h1>
            <p class="subtitle">Système de Gestion de Club de Plongée & Nage avec Palmes</p>

            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-number">100</span>
                    <span class="stat-label">Adhérents</span>
                </div>

                <div class="stat">
                    <span class="stat-number">163+</span>
                    <span class="stat-label">Certifications</span>
                </div>
            </div>
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
