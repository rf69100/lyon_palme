<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeanceEntraineur extends Model
{
    use HasFactory;

    protected $table = 'seance_entraineurs';

    const CREATED_AT = 'cree_le';

    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'seance_id',
        'adherent_id',
        'role',
    ];

    public $timestamps = false;
}
