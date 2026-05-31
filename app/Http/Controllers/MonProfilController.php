<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Espace nageur : consultation et modification de ses propres données
 * personnelles (US14) et choix d'apparition trombinoscope / annuaire (US15/16).
 */
class MonProfilController extends Controller
{
    /**
     * Affiche le profil de l'adhérent lié au compte connecté.
     */
    public function edit(): View
    {
        return view('mon-profil.edit', [
            'adherent' => $this->adherentCourant(),
        ]);
    }

    /**
     * Met à jour les coordonnées et les préférences de visibilité.
     */
    public function update(Request $request): RedirectResponse
    {
        $adherent = $this->adherentCourant();

        if (! $adherent) {
            return redirect()->route('mon-profil.edit')
                ->with('error', 'Aucune fiche adhérent n\'est associée à votre compte.');
        }

        $validated = $request->validate([
            'email' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'numero_rue' => ['nullable', 'string', 'max:10'],
            'rue' => ['nullable', 'string', 'max:255'],
            'complement_adresse' => ['nullable', 'string', 'max:255'],
            'code_postal' => ['nullable', 'string', 'max:10'],
            'ville' => ['nullable', 'string', 'max:100'],
        ], [
            'email.email' => 'L\'adresse email doit être valide.',
        ]);

        // Les cases à cocher absentes valent "non".
        $validated['afficher_trombinoscope'] = $request->boolean('afficher_trombinoscope');
        $validated['afficher_annuaire'] = $request->boolean('afficher_annuaire');

        $adherent->update($validated);

        AuditService::logUpdate('Adherent', $adherent->id, [], $validated);

        return redirect()->route('mon-profil.edit')
            ->with('success', 'Vos informations ont été mises à jour.');
    }

    /**
     * Récupère l'adhérent rattaché à l'utilisateur connecté (ou null).
     */
    private function adherentCourant(): ?Adherent
    {
        return Adherent::where('utilisateur_id', auth()->id())->first();
    }
}
