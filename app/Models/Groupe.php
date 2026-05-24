<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'filiere_id',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id', 'id');
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'groupe_id', 'id');
    }
}