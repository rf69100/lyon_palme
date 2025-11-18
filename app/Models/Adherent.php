<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adherent extends Model
{
    use HasFactory;

    protected $table = 'adherents';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'utilisateur_id',
        'civilite',
        'prenom',
        'nom',
        'date_naissance',
        'email',
        'telephone',
        'mobile',
        'adresse_ligne1',
        'adresse_ligne2',
        'ville',
        'code_postal',
        'pays',
        'profession',
        'photo_url',
        'notes',
        'est_mineur',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'est_mineur' => 'boolean',
    ];
}
