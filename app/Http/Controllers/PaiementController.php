<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaiementRequest;
use App\Models\Adhesion;
use App\Models\Paiement;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaiementController extends Controller
{
    /**
     * Affiche le formulaire d'ajout de paiement.
     */
    public function create(Adhesion $adhesion): View
    {
        $adhesion->load(['adherent', 'saison', 'typeAdhesion']);

        return view('admin.paiements.create', [
            'adhesion' => $adhesion,
            'modesPaiement' => Paiement::MODES_PAIEMENT,
        ]);
    }

    /**
     * Enregistre un nouveau paiement.
     */
    public function store(StorePaiementRequest $request, Adhesion $adhesion): RedirectResponse
    {
        $validated = $request->validated();

        // Créer le paiement
        $paiement = Paiement::create([
            'adhesion_id' => $adhesion->id,
            'montant' => $validated['montant'],
            'moyen_paiement' => $validated['moyen_paiement'],
            'paye_le' => $validated['date_paiement'],
            'reference_paiement' => $validated['numero_recu'] ?? null,
            'remarques' => $validated['remarques'] ?? null,
            'statut' => 'valide',
        ]);

        // Mettre à jour le montant payé de l'adhésion
        $adhesion->increment('montant_paye', $validated['montant']);

        // Audit trail
        AuditService::logCreate('Paiement', $paiement->id, [
            'adhesion_id' => $adhesion->id,
            'adherent' => $adhesion->adherent?->nom.' '.$adhesion->adherent?->prenom,
            'montant' => $validated['montant'],
            'moyen_paiement' => $validated['moyen_paiement'],
        ]);

        return redirect()
            ->route('admin.cotisations.index')
            ->with('success', 'Paiement de '.$validated['montant'].'€ enregistré avec succès.');
    }
}
