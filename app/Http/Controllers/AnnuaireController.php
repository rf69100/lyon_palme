<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\View\View;

/**
 * Annuaire des nageurs (US18) : uniquement les adhérents actifs ayant choisi
 * d'y figurer. Affiche les coordonnées de contact.
 */
class AnnuaireController extends Controller
{
    public function index(): View
    {
        $adherents = Adherent::visibleAnnuaire()
            ->get()
            ->sortBy('nom', SORT_FLAG_CASE | SORT_STRING)
            ->values();

        return view('annuaire.index', compact('adherents'));
    }
}
