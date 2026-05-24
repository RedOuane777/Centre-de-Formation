<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_groupe_enseignant_id',
        'dateE',
        'typeE',
        'salle',
        'heure_debut',
        'heure_fin',
    ];

    public function moduleGroupeEnseignant()
    {
        return $this->belongsTo(ModuleGroupeEnseignant::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
