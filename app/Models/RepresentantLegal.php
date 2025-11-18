<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentantLegal extends Model
{
    use HasFactory;

    protected $table = 'representants_legaux';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_mineur_id',
        'civilite',
        'prenom',
        'nom',
        'lien_parente',
        'email',
        'telephone',
        'mobile',
        'numero_rue',
        'rue',
        'complement_adresse',
        'code_postal',
        'ville',
        'pays',
        'est_principal',
        'peut_recuperer',
        'autorise_sortie',
        'autorise_transport',
    ];
}
