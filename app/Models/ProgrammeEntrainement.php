<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammeEntrainement extends Model
{
    use HasFactory;

    protected $table = 'programmes_entrainement';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'titre',
        'auteur_adherent_id',
        'niveau',
        'duree_minutes',
        'distance_totale',
        'document_id',
        'description',
        'est_modele',
    ];
}
