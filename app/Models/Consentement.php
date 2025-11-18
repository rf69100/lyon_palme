<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consentement extends Model
{
    use HasFactory;

    protected $table = 'consentements';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'adherent_id',
        'type_consentement',
        'accorde',
        'accorde_le',
        'revoque_le',
        'adresse_ip',
        'agent_utilisateur',
    ];

    protected $casts = [
        'accorde' => 'boolean',
        'accorde_le' => 'datetime',
        'revoque_le' => 'datetime',
    ];
}
