<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    const CREATED_AT = 'cree_le';
    const UPDATED_AT = 'modifie_le';

    protected $fillable = [
        'type_documentable',
        'id_documentable',
        'type_document',
        'nom_fichier_original',
        'nom_fichier_stocke',
        'chemin_fichier',
        'hash_fichier',
        'type_mime',
        'taille_fichier',
        'disque_stockage',
        'version',
        'est_archive',
        'televerse_par',
    ];
}
