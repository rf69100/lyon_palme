<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $table = 'certifications';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_id',
        'type_certification',
        'numero_certification',
        'date_delivrance',
        'organisme_delivrance',
        'nom_delivreur',
        'document_id',
        'est_courant',
        'remarques',
    ];
}
