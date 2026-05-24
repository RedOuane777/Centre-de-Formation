<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
    ];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'filiere_id', 'id');
    }

    public function groupes()
    {
        return $this->hasMany(Groupe::class, 'filiere_id', 'id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'filiere_id', 'id');
    }
}