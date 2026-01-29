<?php

namespace App\Http\Controllers;

use App\Exports\CertificatsMedicauxExport;
use App\Models\CertificatMedical;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificatMedicalController extends Controller
{
    /**
     * Affiche la liste des certificats médicaux avec filtres et pagination.
     */
    public function index(Request $request): View
    {
        $query = CertificatMedical::with('adherent');

        // Filtre par statut
        $statut = $request->get('statut', 'tous');
        $today = Carbon::today();

        if ($statut === 'valides') {
            $query->where('expire_le', '>', $today->copy()->addDays(30));
        } elseif ($statut === 'expire_bientot') {
            $query->where('expire_le', '>', $today)
                ->where('expire_le', '<=', $today->copy()->addDays(30));
        } elseif ($statut === 'expires') {
            $query->where('expire_le', '<=', $today);
        }

        // Filtre par questionnaire santé requis
        $questionnaire = $request->get('questionnaire_sante', 'tous');
        $unAnAvant = $today->copy()->subYear();

        if ($questionnaire === 'requis') {
            $query->where('delivre_le', '<', $unAnAvant);
        } elseif ($questionnaire === 'non_requis') {
            $query->where('delivre_le', '>=', $unAnAvant);
        }

        // Tri par date d'expiration ASC (défaut)
        $query->orderBy('expire_le', 'asc');

        // Pagination
        $certificats = $query->paginate(20)->withQueryString();

        // Calcul des données additionnelles pour chaque certificat
        $certificats->getCollection()->transform(function ($certificat) use ($today, $unAnAvant) {
            $expireLe = Carbon::parse($certificat->expire_le);
            $delivreLe = Carbon::parse($certificat->delivre_le);

            // Calcul des jours restants
            $joursRestants = $today->diffInDays($expireLe, false);
            $certificat->jours_restants = $joursRestants;

            // Calcul du statut visuel
            if ($joursRestants <= 0) {
                $certificat->statut_visuel = 'expire';
            } elseif ($joursRestants <= 30) {
                $certificat->statut_visuel = 'expire_bientot';
            } else {
                $certificat->statut_visuel = 'valide';
            }

            // Questionnaire santé requis si certificat > 1 an
            $certificat->questionnaire_sante_requis = $delivreLe->lt($unAnAvant);

            return $certificat;
        });

        return view('admin.certificats-medicaux.index', [
            'certificats' => $certificats,
            'filtreStatut' => $statut,
            'filtreQuestionnaire' => $questionnaire,
        ]);
    }

    /**
     * Exporte la liste des certificats médicaux en Excel.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $statut = $request->get('statut', 'tous');
        $questionnaire = $request->get('questionnaire_sante', 'tous');

        $nomFichier = 'certificats_medicaux_'.now()->format('Y-m-d_His').'.xlsx';

        return Excel::download(
            new CertificatsMedicauxExport($statut, $questionnaire),
            $nomFichier
        );
    }
}
