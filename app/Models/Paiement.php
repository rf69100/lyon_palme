<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adhesion_id',
        'montant',
        'moyen_paiement',
        'reference_paiement',
        'nom_banque',
        'numero_cheque',
        'paye_le',
        'depose_le',
        'statut',
        'remarques',
    ];
}
