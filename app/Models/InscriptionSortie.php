<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionSortie extends Model
{
    use HasFactory;

    protected $table = 'inscriptions_sorties';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'sortie_id',
        'adherent_id',
        'date_inscription',
        'statut',
        'moyen_transport',
        'places_covoiturage_disponibles',
        'nombre_accompagnants',
        'remarques',
        'annule_le',
        'raison_annulation',
    ];
}
