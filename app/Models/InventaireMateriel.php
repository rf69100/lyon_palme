<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireMateriel extends Model
{
    use HasFactory;

    protected $table = 'inventaire_materiel';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'type_materiel_id',
        'code_materiel',
        'marque',
        'taille_ou_pointure',
        'date_achat',
        'prix_achat',
        'etat',
        'statut',
        'remarques',
    ];
}
