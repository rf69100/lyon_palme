<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherentRequest;
use App\Http\Requests\UpdateAdherentRequest;
use App\Models\Adherent;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdherentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->adherent?->estAdministrateur()) {
                abort(403);
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the adherents
     */
    public function index(Request $request): View
    {
        $query = Adherent::query()->with('utilisateur');

        // Filtres
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->rechercherParNom($search)
                    ->orWhere->rechercherParPrenom($search)
                    ->orWhere->rechercherParNomComplet($search, '');
            });
        }

        if ($request->filled('statut')) {
            if ($request->input('statut') === 'actif') {
                $query->actif();
            } elseif ($request->input('statut') === 'archive') {
                $query->archive();
            }
        }

        if ($request->filled('type')) {
            if ($request->input('type') === 'mineur') {
                $query->mineur();
            } elseif ($request->input('type') === 'majeur') {
                $query->majeur();
            }
        }

        // Tri
        $sortBy = $request->input('sort_by', 'nom');
        $sortDirection = $request->input('sort_direction', 'asc');

        $adherents = $query->orderBy($sortBy, $sortDirection)->paginate(20);

        return view('admin.adherents.index', compact('adherents'));
    }

    /**
     * Show the form for creating a new adherent
     */
    public function create(): View
    {
        return view('admin.adherents.create');
    }

    /**
     * Store a newly created adherent in storage
     */
    public function store(StoreAdherentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $adherent = Adherent::create($validated);

        AuditService::logCreate('Adherent', $adherent->id, $validated);

        return redirect()
            ->route('admin.adherents.show', $adherent)
            ->with('success', 'Adhérent créé avec succès.');
    }

    /**
     * Display the specified adherent
     */
    public function show(Adherent $adherent): View
    {
        $adherent->load([
            'utilisateur',
            'representantsLegaux',
            'adhesions.saison',
            'adhesions.typeAdhesion',
            'roles',
        ]);

        return view('admin.adherents.show', compact('adherent'));
    }

    /**
     * Show the form for editing the specified adherent
     */
    public function edit(Adherent $adherent): View
    {
        return view('admin.adherents.edit', compact('adherent'));
    }

    /**
     * Update the specified adherent in storage
     */
    public function update(UpdateAdherentRequest $request, Adherent $adherent): RedirectResponse
    {
        $validated = $request->validated();

        $oldValues = $adherent->toArray();
        $adherent->update($validated);

        AuditService::logUpdate('Adherent', $adherent->id, $oldValues, $validated);

        return redirect()
            ->route('admin.adherents.show', $adherent)
            ->with('success', 'Adhérent mis à jour avec succès.');
    }

    /**
     * Archive the specified adherent
     */
    public function destroy(Adherent $adherent): RedirectResponse
    {
        // Ne pas supprimer, mais archiver
        $oldValues = $adherent->toArray();
        $adherent->archiver();

        AuditService::logUpdate('Adherent', $adherent->id, $oldValues, ['statut' => 'archive']);

        return redirect()
            ->route('admin.adherents.index')
            ->with('success', 'Adhérent archivé avec succès.');
    }

    /**
     * Restore an archived adherent
     */
    public function restore(Adherent $adherent): RedirectResponse
    {
        $oldValues = $adherent->toArray();
        $adherent->reactiver();

        AuditService::logUpdate('Adherent', $adherent->id, $oldValues, ['statut' => 'actif']);

        return redirect()
            ->route('admin.adherents.show', $adherent)
            ->with('success', 'Adhérent réactivé avec succès.');
    }
}
