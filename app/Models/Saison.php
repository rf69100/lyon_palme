<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    use HasFactory;

    protected $table = 'saisons';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'est_courante',
    ];

    protected $casts = [
        'est_courante' => 'boolean',
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];
}
