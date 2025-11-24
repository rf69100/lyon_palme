<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil - Lyon Palme</title>
    @vite(['resources/css/app.css'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: white;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        nav h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4338ca;
        }
        nav a {
            text-decoration: none;
            margin-left: 1rem;
            font-weight: 500;
        }
        nav a.login {
            color: #4338ca;
        }
        nav a.register {
            color: white;
            background: #4338ca;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }
        .hero {
            background: linear-gradient(to bottom right, #0f3460, #4a90e2);
            color: white;
            padding: 5rem 2rem;
            text-align: center;
        }
        .hero h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        .hero-buttons a {
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
        }
        .hero-buttons a.primary {
            background: white;
            color: #4338ca;
        }
        .hero-buttons a.secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        .features {
            max-width: 1280px;
            margin: 3rem auto;
            padding: 0 2rem;
        }
        .features h3 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #111827;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        .feature-card {
            padding: 1.5rem;
            border-left: 4px solid;
            border-radius: 0.5rem;
            background: #fafafa;
        }
        .feature-card h4 {
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
            color: #111827;
        }
        .feature-card p {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        .card-1 { border-color: #3b82f6; background: #eff6ff; }
        .card-2 { border-color: #22c55e; background: #f0fdf4; }
        .card-3 { border-color: #ef4444; background: #fef2f2; }
        .card-4 { border-color: #a855f7; background: #faf5ff; }
        .card-5 { border-color: #eab308; background: #fefce8; }
        .card-6 { border-color: #4338ca; background: #eef2ff; }
        .card-7 { border-color: #f97316; background: #fff7ed; }
        .card-8 { border-color: #06b6d4; background: #ecf8ff; }
        .card-9 { border-color: #ec4899; background: #fff1f8; }
        .cta {
            background: #4338ca;
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            margin: 3rem 0;
        }
        .cta h3 {
            font-size: 1.875rem;
            margin-bottom: 1rem;
        }
        .cta p {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .cta a {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: white;
            color: #4338ca;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
        }
        footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 2rem;
            text-align: center;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <h1>🏊 Lyon Palme</h1>
        <div>
            <a href="{{ route('login') }}" class="login">Connexion</a>
            <a href="{{ route('register') }}" class="register">S'inscrire</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <h2>Bienvenue à Lyon Palme</h2>
        <p>La plateforme complète de gestion pour votre club de plongée</p>
        <div class="hero-buttons">
            <a href="{{ route('register') }}" class="primary">Commencer maintenant</a>
            <a href="{{ route('login') }}" class="secondary">Se connecter</a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features">
        <h3>Nos fonctionnalités</h3>
        <div class="features-grid">
            <div class="feature-card card-1">
                <h4>👥 Gestion des adhérents</h4>
                <p>Gérez facilement vos adhérents, leurs certifications et leurs dossiers médicaux conformément à la RGPD.</p>
            </div>

            <div class="feature-card card-2">
                <h4>💳 Adhésions et paiements</h4>
                <p>Suivez les cotisations et paiements de vos membres avec un suivi complet et fiable.</p>
            </div>

            <div class="feature-card card-3">
                <h4>🏥 Certificats médicaux</h4>
                <p>Conservez et gérez les certificats médicaux de manière sécurisée et conforme à la réglementation.</p>
            </div>

            <div class="feature-card card-4">
                <h4>🎓 Certifications</h4>
                <p>Suivez les certifications et brevets de plongée de vos adhérents à jour.</p>
            </div>

            <div class="feature-card card-5">
                <h4>📚 Entraînement</h4>
                <p>Organisez des séances et programmes d'entraînement pour tous les niveaux.</p>
            </div>

            <div class="feature-card card-6">
                <h4>🌊 Sorties et compétitions</h4>
                <p>Planifiez et gérez les sorties en mer et les compétitions de votre club.</p>
            </div>

            <div class="feature-card card-7">
                <h4>🔧 Gestion du matériel</h4>
                <p>Inventoriez et gérez l'équipement de plongée et d'entraînement du club.</p>
            </div>

            <div class="feature-card card-8">
                <h4>📄 Gestion des documents</h4>
                <p>Centralisez les documents importants du club en un seul endroit sécurisé.</p>
            </div>

            <div class="feature-card card-9">
                <h4>🔐 Sécurité RGPD</h4>
                <p>Votre plateforme est entièrement conforme à la réglementation RGPD avec chiffrement de bout en bout.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta">
        <h3>Prêt à gérer votre club ?</h3>
        <p>Rejoignez les clubs de plongée qui font confiance à Lyon Palme</p>
        <a href="{{ route('register') }}">Créer un compte maintenant</a>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Lyon Palme - Gestion de Club de Plongée. Tous droits réservés.</p>
        <p>Conforme RGPD • Sécurisé • Fiable</p>
    </footer>
</body>
</html>
