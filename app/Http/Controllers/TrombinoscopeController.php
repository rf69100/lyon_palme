<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\View\View;

/**
 * Trombinoscope des nageurs (US17) : uniquement les adhérents actifs ayant
 * choisi d'y apparaître.
 */
class TrombinoscopeController extends Controller
{
    public function index(): View
    {
        $adherents = Adherent::visibleTrombinoscope()
            ->with('roles')
            ->get()
            ->sortBy('nom', SORT_FLAG_CASE | SORT_STRING)
            ->values();

        return view('trombinoscope.index', compact('adherents'));
    }
}
