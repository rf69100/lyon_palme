<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdherentRequest;
use App\Http\Requests\UpdateAdherentRequest;
use App\Models\Adherent;
use App\Models\CertificatMedical;
use App\Models\Consentement;
use App\Models\Document;
use App\Models\RepresentantLegal;
use App\Models\Role;
use App\Models\Utilisateur;
use App\Services\AuditService;
use App\Services\FileSecurityService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdherentController extends Controller
{
    /** Colonnes réellement persistées sur le modèle Adherent. */
    private const ADHERENT_FIELDS = [
        'civilite', 'prenom', 'nom', 'date_naissance', 'email', 'telephone',
        'mobile', 'numero_rue', 'rue', 'complement_adresse', 'code_postal',
        'ville', 'statut',
    ];

    /**
     * Display a listing of the adherents
     */
    public function index(Request $request): View
    {
        $query = Adherent::query()->with('utilisateur');

        // Recherche : les colonnes nom/prenom étant chiffrées, on interroge les
        // colonnes de hachage (correspondance exacte sur nom, prénom ou nom complet).
        if ($request->filled('search')) {
            $hash = hash('sha256', mb_strtolower(trim($request->input('search'))));
            $query->where(function ($q) use ($hash) {
                $q->where('nom_recherche', $hash)
                    ->orWhere('prenom_recherche', $hash)
                    ->orWhere('nom_complet_recherche', $hash);
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

        // Tri : on restreint aux colonnes non chiffrées (trier par nom/prénom
        // chiffrés n'aurait aucun sens et exposerait à l'injection de colonne).
        $sortable = ['cree_le', 'statut', 'est_mineur', 'id'];
        $sortBy = in_array($request->input('sort_by'), $sortable, true)
            ? $request->input('sort_by')
            : 'cree_le';
        $sortDirection = $request->input('sort_direction') === 'asc' ? 'asc' : 'desc';

        $adherents = $query->orderBy($sortBy, $sortDirection)
            ->paginate(20)
            ->withQueryString();

        return view('admin.adherents.index', compact('adherents'));
    }

    /**
     * Show the form for creating a new adherent
     */
    public function create(): View
    {
        $roles = Role::orderBy('nom_affichage')->get();

        return view('admin.adherents.create', compact('roles'));
    }

    /**
     * Store a newly created adherent in storage
     */
    public function store(StoreAdherentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $adherent = DB::transaction(function () use ($request, $validated) {
            $adherent = Adherent::create($this->adherentData($validated));

            $this->syncRoles($adherent, $validated['roles'] ?? []);

            if (! empty($validated['est_mineur'])) {
                $this->saveRepresentantLegal($adherent, $validated);
                $this->recordConsentement($adherent, 'autorisation_parentale');
            }

            $this->recordConsentement($adherent, 'traitement_donnees');
            $this->storeCertificatMedical($adherent, $request, $validated);

            return $adherent;
        });

        AuditService::logCreate('Adherent', $adherent->id, $this->adherentData($validated));

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
            'certificatsMedicaux.document',
        ]);

        return view('admin.adherents.show', compact('adherent'));
    }

    /**
     * Show the form for editing the specified adherent
     */
    public function edit(Adherent $adherent): View
    {
        $adherent->load(['representantsLegaux', 'roles']);

        $roles = Role::orderBy('nom_affichage')->get();
        $selectedRoles = $adherent->roles->pluck('id')->all();
        $representant = $adherent->representantsLegaux->firstWhere('est_principal', true)
            ?? $adherent->representantsLegaux->first();

        return view('admin.adherents.edit', compact('adherent', 'roles', 'selectedRoles', 'representant'));
    }

    /**
     * Update the specified adherent in storage
     */
    public function update(UpdateAdherentRequest $request, Adherent $adherent): RedirectResponse
    {
        $validated = $request->validated();
        $oldValues = $adherent->toArray();

        DB::transaction(function () use ($request, $validated, $adherent) {
            $adherent->update($this->adherentData($validated));

            $this->syncRoles($adherent, $validated['roles'] ?? []);

            if (! empty($validated['est_mineur'])) {
                $this->saveRepresentantLegal($adherent, $validated);
            }

            $this->storeCertificatMedical($adherent, $request, $validated);
        });

        AuditService::logUpdate('Adherent', $adherent->id, $oldValues, $this->adherentData($validated));

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

    /**
     * Crée un compte de connexion (Utilisateur) pour un adhérent (US12).
     * Login = email ; mot de passe initial = date de naissance (AAAAMMJJ),
     * à changer à la première connexion.
     */
    public function createAccount(Adherent $adherent): RedirectResponse
    {
        if ($adherent->utilisateur_id) {
            return back()->with('error', 'Cet adhérent possède déjà un compte de connexion.');
        }

        if (! $adherent->email) {
            return back()->with('error', 'Une adresse email est requise pour créer un compte.');
        }

        if (Utilisateur::where('email', $adherent->email)->exists()) {
            return back()->with('error', 'Un compte existe déjà avec cette adresse email.');
        }

        $motDePasseInitial = Carbon::parse($adherent->date_naissance)->format('Ymd');

        $utilisateur = Utilisateur::create([
            'nom' => $adherent->nom_complet,
            'email' => $adherent->email,
            'mot_de_passe' => $motDePasseInitial, // haché via le cast "hashed"
            'email_verifie_le' => now(),
            'doit_changer_mdp' => true,
        ]);

        $adherent->update(['utilisateur_id' => $utilisateur->id]);

        AuditService::logCreate('Utilisateur', $utilisateur->id, ['email' => $adherent->email]);

        return back()->with('success', 'Compte créé. Mot de passe initial : date de naissance au format AAAAMMJJ (à changer à la première connexion).');
    }

    /**
     * Extrait les seules colonnes de l'adhérent depuis les données validées,
     * et y ajoute le statut mineur calculé.
     */
    private function adherentData(array $validated): array
    {
        $data = array_intersect_key($validated, array_flip(self::ADHERENT_FIELDS));
        $data['est_mineur'] = (bool) ($validated['est_mineur'] ?? false);

        return $data;
    }

    /**
     * (Ré)attribue les rôles sélectionnés à l'adhérent.
     */
    private function syncRoles(Adherent $adherent, array $roleIds): void
    {
        $payload = [];
        foreach ($roleIds as $roleId) {
            $payload[$roleId] = ['attribue_le' => now(), 'revoque_le' => null, 'est_actif' => true];
        }

        $adherent->roles()->sync($payload);
    }

    /**
     * Crée ou met à jour le représentant légal principal d'un adhérent mineur.
     */
    private function saveRepresentantLegal(Adherent $adherent, array $v): void
    {
        if (empty($v['representant_nom']) || empty($v['representant_prenom'])) {
            return;
        }

        RepresentantLegal::updateOrCreate(
            ['adherent_mineur_id' => $adherent->id, 'est_principal' => true],
            [
                'civilite' => $v['representant_civilite'] ?? 'M.',
                'prenom' => $v['representant_prenom'],
                'nom' => $v['representant_nom'],
                'lien_parente' => $v['representant_lien_parente'] ?? 'Parent',
                'email' => $v['representant_email'] ?? null,
                'telephone' => $v['representant_telephone'] ?? null,
                'mobile' => $v['representant_mobile'] ?? null,
                'est_principal' => true,
            ]
        );
    }

    /**
     * Enregistre un consentement RGPD avec traçabilité IP / User-Agent.
     */
    private function recordConsentement(Adherent $adherent, string $type): void
    {
        Consentement::create([
            'adherent_id' => $adherent->id,
            'type_consentement' => $type,
            'accorde' => true,
            'accorde_le' => now(),
            'adresse_ip' => request()->ip(),
            'agent_utilisateur' => request()->userAgent(),
        ]);
    }

    /**
     * Stocke le PDF du certificat médical (Document + CertificatMedical).
     * Validité 3 ans à compter de la date de délivrance (règle de gestion club).
     */
    private function storeCertificatMedical(Adherent $adherent, Request $request, array $v): void
    {
        if (! $request->hasFile('certificat_pdf')) {
            return;
        }

        $file = $request->file('certificat_pdf');

        $errors = FileSecurityService::validateUploadedFile($file);
        if (! empty($errors)) {
            throw ValidationException::withMessages(['certificat_pdf' => $errors]);
        }

        $hash = hash_file('sha256', $file->getRealPath());
        $original = $file->getClientOriginalName();
        $size = $file->getSize();
        $mime = $file->getMimeType();

        $path = FileSecurityService::storeFile($file, 'certificats_medicaux');
        if (! $path) {
            throw ValidationException::withMessages([
                'certificat_pdf' => 'Le téléversement du certificat a échoué.',
            ]);
        }

        $document = Document::create([
            'type_documentable' => Adherent::class,
            'id_documentable' => $adherent->id,
            'type_document' => 'certificat_medical',
            'nom_fichier_original' => $original,
            'nom_fichier_stocke' => basename($path),
            'chemin_fichier' => $path,
            'hash_fichier' => $hash,
            'type_mime' => $mime,
            'taille_fichier' => $size,
            'disque_stockage' => 'local',
            'televerse_par' => auth()->id(),
        ]);

        $delivreLe = Carbon::parse($v['certificat_delivre_le']);

        CertificatMedical::create([
            'adherent_id' => $adherent->id,
            'document_id' => $document->id,
            'delivre_le' => $delivreLe->toDateString(),
            'expire_le' => $delivreLe->copy()->addYears(3)->toDateString(),
            'statut' => 'valide',
            'questionnaire_sante_fourni' => false,
        ]);
    }
}
