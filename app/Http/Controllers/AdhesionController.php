<?php

namespace App\Http\Controllers;

use App\Exports\CotisationsExport;
use App\Models\Adhesion;
use App\Models\Saison;
use App\Models\TypeAdhesion;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdhesionController extends Controller
{
    /**
     * Affiche la liste des cotisations avec filtres et pagination.
     */
    public function index(Request $request): View
    {
        $query = Adhesion::with(['adherent', 'saison', 'typeAdhesion', 'paiements']);

        // Filtre par saison
        $saisonId = $request->get('saison_id', 'toutes');
        if ($saisonId === 'courante') {
            $saisonCourante = Saison::where('est_courante', true)->first();
            if ($saisonCourante) {
                $query->where('saison_id', $saisonCourante->id);
            }
        } elseif ($saisonId !== 'toutes' && is_numeric($saisonId)) {
            $query->where('saison_id', $saisonId);
        }

        // Filtre par statut paiement
        $statutPaiement = $request->get('statut_paiement', 'tous');
        if ($statutPaiement === 'a_jour') {
            $query->whereRaw('solde <= 0');
        } elseif ($statutPaiement === 'partiels') {
            $query->where('montant_paye', '>', 0)
                ->whereRaw('solde > 0');
        } elseif ($statutPaiement === 'impayes') {
            $query->where('montant_paye', '=', 0)
                ->whereRaw('solde > 0');
        }

        // Filtre par type d'adhésion
        $typeAdhesionId = $request->get('type_adhesion_id', 'tous');
        if ($typeAdhesionId !== 'tous' && is_numeric($typeAdhesionId)) {
            $query->where('type_adhesion_id', $typeAdhesionId);
        }

        // Tri par solde DESC (impayés en premier)
        $query->orderByRaw('solde DESC, montant_paye ASC');

        // Pagination
        $adhesions = $query->paginate(20)->withQueryString();

        // Récupérer les saisons et types pour les filtres
        $saisons = Saison::orderBy('date_debut', 'desc')->get();
        $typesAdhesion = TypeAdhesion::where('est_actif', true)->get();

        return view('admin.cotisations.index', [
            'adhesions' => $adhesions,
            'saisons' => $saisons,
            'typesAdhesion' => $typesAdhesion,
            'filtreSaison' => $saisonId,
            'filtreStatut' => $statutPaiement,
            'filtreType' => $typeAdhesionId,
        ]);
    }

    /**
     * Exporte la liste des cotisations en Excel.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $saisonId = $request->get('saison_id', 'toutes');
        $statutPaiement = $request->get('statut_paiement', 'tous');
        $typeAdhesionId = $request->get('type_adhesion_id', 'tous');

        $nomFichier = 'cotisations_'.now()->format('Y-m-d_His').'.xlsx';

        return Excel::download(
            new CotisationsExport($saisonId, $statutPaiement, $typeAdhesionId),
            $nomFichier
        );
    }
}
