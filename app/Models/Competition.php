<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $table = 'competitions';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'saison_id',
        'titre',
        'organisation',
        'comite_regional',
        'date_competition',
        'lieu',
        'site',
        'date_limite_inscription',
        'url_inscription',
        'participants_max',
        'statut',
        'est_regionale',
        'est_nationale',
        'necessite_hebergement',
        'info_hebergement',
        'remarques',
    ];
}
