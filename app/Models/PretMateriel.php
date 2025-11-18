<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretMateriel extends Model
{
    use HasFactory;

    protected $table = 'prets_materiel';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'materiel_id',
        'adherent_id',
        'saison_id',
        'prete_le',
        'date_retour_prevue',
        'rendu_le',
        'etat_au_retour',
        'gere_par',
        'remarques',
    ];

    protected $casts = [
        'prete_le' => 'date',
        'date_retour_prevue' => 'date',
        'rendu_le' => 'date',
    ];
}
