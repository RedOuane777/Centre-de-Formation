<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'module_groupe_enseignant_id',
        'note_id',
        'nom',
        'fichier',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id');
    }

    public function moduleGroupeEnseignant()
    {
        return $this->belongsTo(ModuleGroupeEnseignant::class);
    }

    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id', 'id');
    }
}
