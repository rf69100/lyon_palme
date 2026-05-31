<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarifs';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'saison_id',
        'type_adhesion_id',
        'montant',
        'description',
        'valide_du',
        'valide_jusque',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'valide_du' => 'date',
        'valide_jusque' => 'date',
    ];
}
