<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatMedical extends Model
{
    use HasFactory;

    protected $table = 'certificats_medicaux';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_id',
        'document_id',
        'delivre_le',
        'expire_le',
        'types_pratique',
        'nom_medecin',
        'numero_ordre_medecin',
        'est_medecin_federal',
        'restrictions',
        'questionnaire_sante_fourni',
        'statut',
    ];
}
