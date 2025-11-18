<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adhesion extends Model
{
    use HasFactory;

    protected $table = 'adhesions';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_id',
        'saison_id',
        'type_adhesion_id',
        'tarif_id',
        'montant_attendu',
        'montant_paye',
        'date_inscription',
        'statut',
        'valide_le',
        'valide_par',
        'numero_recu',
        'remarques',
    ];
}
