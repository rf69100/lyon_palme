<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Adhesion;
use App\Models\Paiement;
use App\Models\InscriptionSortie;
use App\Models\InscriptionCompetition;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role
     */
    public function index(): View
    {
        $user = auth()->user();

        // Get adherent associated with this user
        $adherent = Adherent::where('utilisateur_id', $user->id)->first();

        // TODO: Integrate with role system once AdherentRole model is created
        // For now, all users see the adherent dashboard
        // Future: Check if user has secretary/admin role from adherent_roles table

        // Display adherent dashboard
        return $this->adherentDashboard($adherent);
    }

    /**
     * Display adherent's personal dashboard
     */
    private function adherentDashboard(?Adherent $adherent): View
    {
        $stats = [
            'nom_complet' => auth()->user()->nom ?? 'Utilisateur',
            'statut' => $adherent?->statut ?? 'inactif',
            'totalAdhesions' => 0,
            'activitesParticipees' => 0,
            'certificationsCount' => 0,
        ];

        // Get active adhesions (memberships)
        $adhesions = collect([]);
        $upcomingOutings = collect([]);
        $upcomingCompetitions = collect([]);

        if ($adherent) {
            try {
                $adhesions = $adherent->adhesions()
                    ->orderBy('cree_le', 'desc')
                    ->take(5)
                    ->get();
                $stats['totalAdhesions'] = $adhesions->count();
            } catch (\Exception $e) {
                \Log::error('Error loading adhesions: ' . $e->getMessage());
                $adhesions = collect([]);
            }

            try {
                // Get upcoming sorties (outings)
                $upcomingOutings = InscriptionSortie::where('adherent_id', $adherent->id)
                    ->orderBy('cree_le', 'desc')
                    ->take(5)
                    ->get();
                $stats['activitesParticipees'] = $upcomingOutings->count();
            } catch (\Exception $e) {
                \Log::error('Error loading outings: ' . $e->getMessage());
                $upcomingOutings = collect([]);
            }

            try {
                // Get upcoming competitions
                $upcomingCompetitions = InscriptionCompetition::where('adherent_id', $adherent->id)
                    ->orderBy('cree_le', 'desc')
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Error loading competitions: ' . $e->getMessage());
                $upcomingCompetitions = collect([]);
            }
        }

        return view('dashboard.adherent', [
            'stats' => $stats,
            'adhesions' => $adhesions,
            'upcomingOutings' => $upcomingOutings,
            'upcomingCompetitions' => $upcomingCompetitions,
            'adherent' => $adherent,
        ]);
    }

    /**
     * Display secretary's administrative dashboard
     */
    private function secretaryDashboard(): View
    {
        // Total members count
        $totalMembers = Adherent::actif()->count();
        $totalArchived = Adherent::archive()->count();
        $totalMinors = Adherent::mineur()->count();

        // Adhesions statistics
        $totalAdhesions = Adhesion::count();
        $activeAdhesions = Adhesion::whereDate('date_fin', '>=', now())->count();
        $expiredAdhesions = Adhesion::whereDate('date_fin', '<', now())->count();

        // Recent members
        $recentMembers = Adherent::actif()
            ->orderBy('cree_le', 'desc')
            ->take(10)
            ->get();

        // Adhesions expiring soon (next 30 days)
        $expiringAdhesions = Adhesion::whereBetween('date_fin', [
            now(),
            now()->addDays(30)
        ])->with('adherent', 'typeAdhesion')
            ->orderBy('date_fin', 'asc')
            ->take(10)
            ->get();

        // Payment statistics
        $totalPayments = Paiement::count();
        $pendingPayments = Paiement::where('statut', 'en_attente')->count();

        // Activity statistics
        $totalOutings = \App\Models\Sortie::count();
        $totalCompetitions = \App\Models\Competition::count();

        return view('dashboard.secretary', [
            'totalMembers' => $totalMembers,
            'totalArchived' => $totalArchived,
            'totalMinors' => $totalMinors,
            'totalAdhesions' => $totalAdhesions,
            'activeAdhesions' => $activeAdhesions,
            'expiredAdhesions' => $expiredAdhesions,
            'recentMembers' => $recentMembers,
            'expiringAdhesions' => $expiringAdhesions,
            'totalPayments' => $totalPayments,
            'pendingPayments' => $pendingPayments,
            'totalOutings' => $totalOutings,
            'totalCompetitions' => $totalCompetitions,
        ]);
    }
}
