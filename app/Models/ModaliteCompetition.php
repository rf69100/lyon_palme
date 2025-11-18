<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModaliteCompetition extends Model
{
    use HasFactory;

    protected $table = 'modalites_competition';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'competition_id',
        'nom',
        'description',
        'distance_metres',
        'discipline',
    ];
}
