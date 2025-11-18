<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    protected $table = 'utilisateurs';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'nom',
        'email',
        'email_verifie_le',
        'mot_de_passe',
        'doit_changer_mdp',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $casts = [
        'email_verifie_le' => 'datetime',
        'doit_changer_mdp' => 'boolean',
    ];
}
