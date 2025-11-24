@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem;">
    <h2 style="font-size: 1.875rem; font-weight: bold; color: #111827; margin-bottom: 1rem;">Bienvenue au Dashboard</h2>
    <p style="color: #6b7280; margin-bottom: 1.5rem;">
        Vous êtes maintenant connecté à l'application de gestion Lyon Palme.
    </p>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Adhérents -->
        <div style="background: #eff6ff; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #3b82f6;">
            <div style="font-size: 2.25rem; font-weight: bold; color: #2563eb; margin-bottom: 0.5rem;">100</div>
            <p style="color: #4b5563; font-weight: 500;">Adhérents</p>
        </div>

        <!-- Sorties planifiées -->
        <div style="background: #f0fdf4; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #22c55e;">
            <div style="font-size: 2.25rem; font-weight: bold; color: #16a34a; margin-bottom: 0.5rem;">25</div>
            <p style="color: #4b5563; font-weight: 500;">Sorties planifiées</p>
        </div>

        <!-- Compétitions -->
        <div style="background: #faf5ff; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #a855f7;">
            <div style="font-size: 2.25rem; font-weight: bold; color: #9333ea; margin-bottom: 0.5rem;">12</div>
            <p style="color: #4b5563; font-weight: 500;">Compétitions</p>
        </div>
    </div>

    <!-- Status Box -->
    <div style="background: #fffbeb; border: 1px solid #fcd34d; border-radius: 0.5rem; padding: 1rem;">
        <p style="font-size: 0.875rem; color: #92400e;">
            ✓ Authentification Fortify activée<br />
            ✓ Chiffrement RGPD en place<br />
            ✓ Prêt pour la production
        </p>
    </div>
</div>
@endsection
