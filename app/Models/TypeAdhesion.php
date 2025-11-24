<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAdhesion extends Model
{
    use HasFactory;

    protected $table = 'types_adhesion';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'nom',
        'description',
        'necessite_justificatif',
        'est_actif',
    ];

    protected $casts = [
        'necessite_justificatif' => 'boolean',
        'est_actif' => 'boolean',
    ];
}
