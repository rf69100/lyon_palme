<?php

namespace App\Exports;

use App\Models\CertificatMedical;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CertificatsMedicauxExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private string $statut = 'tous',
        private string $questionnaire = 'tous'
    ) {}

    /**
     * Récupère la collection de certificats à exporter.
     */
    public function collection()
    {
        $query = CertificatMedical::with('adherent');
        $today = Carbon::today();
        $unAnAvant = $today->copy()->subYear();

        // Filtre par statut
        if ($this->statut === 'valides') {
            $query->where('expire_le', '>', $today->copy()->addDays(30));
        } elseif ($this->statut === 'expire_bientot') {
            $query->where('expire_le', '>', $today)
                ->where('expire_le', '<=', $today->copy()->addDays(30));
        } elseif ($this->statut === 'expires') {
            $query->where('expire_le', '<=', $today);
        }

        // Filtre par questionnaire santé
        if ($this->questionnaire === 'requis') {
            $query->where('delivre_le', '<', $unAnAvant);
        } elseif ($this->questionnaire === 'non_requis') {
            $query->where('delivre_le', '>=', $unAnAvant);
        }

        return $query->orderBy('expire_le', 'asc')->get();
    }

    /**
     * En-têtes des colonnes Excel.
     */
    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Email',
            'Date d\'émission',
            'Date d\'expiration',
            'Jours restants',
            'Statut',
            'Questionnaire santé requis',
        ];
    }

    /**
     * Mapping des données pour chaque ligne.
     */
    public function map($certificat): array
    {
        $today = Carbon::today();
        $expireLe = Carbon::parse($certificat->expire_le);
        $delivreLe = Carbon::parse($certificat->delivre_le);
        $unAnAvant = $today->copy()->subYear();

        $joursRestants = $today->diffInDays($expireLe, false);

        // Calcul du statut
        if ($joursRestants <= 0) {
            $statut = 'Expiré';
        } elseif ($joursRestants <= 30) {
            $statut = 'Expire bientôt';
        } else {
            $statut = 'Valide';
        }

        // Questionnaire santé requis
        $questionnaireRequis = $delivreLe->lt($unAnAvant) ? 'Oui' : 'Non';

        return [
            $certificat->adherent?->nom ?? 'N/A',
            $certificat->adherent?->prenom ?? 'N/A',
            $certificat->adherent?->email ?? 'N/A',
            $certificat->delivre_le?->format('d/m/Y') ?? 'N/A',
            $certificat->expire_le?->format('d/m/Y') ?? 'N/A',
            $joursRestants,
            $statut,
            $questionnaireRequis,
        ];
    }

    /**
     * Styles pour le fichier Excel.
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF5B4B8A'],
                ],
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            ],
        ];
    }
}
