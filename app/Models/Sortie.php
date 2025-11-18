<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    use HasFactory;

    protected $table = 'sorties';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'saison_id',
        'titre',
        'type_sortie',
        'date_sortie',
        'heure_rendez_vous',
        'heure_debut',
        'lieu',
        'zone_plage',
        'niveau_requis',
        'participants_max',
        'organisateur_adherent_id',
        'consignes_securite',
        'remarques_complementaires',
        'conditions_meteo',
        'temperature_eau',
        'statut',
        'raison_annulation',
    ];
}
