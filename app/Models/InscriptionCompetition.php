<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionCompetition extends Model
{
    use HasFactory;

    protected $table = 'inscriptions_competitions';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'competition_id',
        'adherent_id',
        'modalite_competition_id',
        'date_inscription',
        'statut',
        'moyen_transport',
        'places_covoiturage_disponibles',
        'besoin_hebergement',
        'nombre_accompagnants',
        'info_hebergement',
        'temps_performance',
        'classement',
        'remarques',
        'annule_le',
        'raison_annulation',
    ];
}
