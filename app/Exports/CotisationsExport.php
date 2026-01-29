<?php

namespace App\Exports;

use App\Models\Adhesion;
use App\Models\Saison;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CotisationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private string $saisonId = 'toutes',
        private string $statutPaiement = 'tous',
        private string $typeAdhesionId = 'tous'
    ) {}

    /**
     * Récupère la collection de cotisations à exporter.
     */
    public function collection()
    {
        $query = Adhesion::with(['adherent', 'saison', 'typeAdhesion', 'paiements']);

        // Filtre par saison
        if ($this->saisonId === 'courante') {
            $saisonCourante = Saison::where('est_courante', true)->first();
            if ($saisonCourante) {
                $query->where('saison_id', $saisonCourante->id);
            }
        } elseif ($this->saisonId !== 'toutes' && is_numeric($this->saisonId)) {
            $query->where('saison_id', $this->saisonId);
        }

        // Filtre par statut paiement
        if ($this->statutPaiement === 'a_jour') {
            $query->whereRaw('solde <= 0');
        } elseif ($this->statutPaiement === 'partiels') {
            $query->where('montant_paye', '>', 0)
                ->whereRaw('solde > 0');
        } elseif ($this->statutPaiement === 'impayes') {
            $query->where('montant_paye', '=', 0)
                ->whereRaw('solde > 0');
        }

        // Filtre par type d'adhésion
        if ($this->typeAdhesionId !== 'tous' && is_numeric($this->typeAdhesionId)) {
            $query->where('type_adhesion_id', $this->typeAdhesionId);
        }

        return $query->orderByRaw('solde DESC')->get();
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
            'Saison',
            'Type d\'adhésion',
            'Montant total',
            'Montant payé',
            'Solde',
            'Dernier paiement',
            'Mode paiement',
            'Statut',
        ];
    }

    /**
     * Mapping des données pour chaque ligne.
     */
    public function map($adhesion): array
    {
        $dernierPaiement = $adhesion->paiements->sortByDesc('paye_le')->first();

        // Calcul du statut
        $solde = (float) $adhesion->solde;
        $montantPaye = (float) $adhesion->montant_paye;

        if ($solde <= 0) {
            $statut = 'À jour';
        } elseif ($montantPaye > 0) {
            $statut = 'Partiel';
        } else {
            $statut = 'Impayé';
        }

        return [
            $adhesion->adherent?->nom ?? 'N/A',
            $adhesion->adherent?->prenom ?? 'N/A',
            $adhesion->adherent?->email ?? 'N/A',
            $adhesion->saison?->nom ?? 'N/A',
            $adhesion->typeAdhesion?->nom ?? 'N/A',
            number_format((float) $adhesion->montant_attendu, 2, ',', ' ').'€',
            number_format((float) $adhesion->montant_paye, 2, ',', ' ').'€',
            number_format((float) $adhesion->solde, 2, ',', ' ').'€',
            $dernierPaiement?->paye_le?->format('d/m/Y') ?? 'Aucun',
            $dernierPaiement ? ($dernierPaiement->mode_paiement_libelle ?? $dernierPaiement->moyen_paiement) : 'N/A',
            $statut,
        ];
    }

    /**
     * Styles pour le fichier Excel.
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF5B4B8A'],
                ],
            ],
        ];
    }
}
