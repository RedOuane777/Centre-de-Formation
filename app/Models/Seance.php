<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_groupe_enseignant_id',
        'date',
        'heure_debut',
        'heure_fin',
        'salle',
    ];

    public function moduleGroupeEnseignant()
    {
        return $this->belongsTo(ModuleGroupeEnseignant::class);
    }
}