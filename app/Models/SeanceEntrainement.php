<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeanceEntrainement extends Model
{
    use HasFactory;

    protected $table = 'seances_entrainement';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'saison_id',
        'date_seance',
        'heure_debut',
        'heure_fin',
        'piscine',
        'longueur_bassin',
        'participants_max',
        'niveau_requis',
        'statut',
        'raison_annulation',
        'remarques',
    ];
}
