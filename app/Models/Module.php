<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'heures',
        'filiere_id',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id', 'id');
    }

    public function examens()
    {
        return $this->hasMany(Examen::class);
    }
    
    public function moduleGroupeEnseignants()
    {
        return $this->hasMany(ModuleGroupeEnseignant::class);
    }
}
