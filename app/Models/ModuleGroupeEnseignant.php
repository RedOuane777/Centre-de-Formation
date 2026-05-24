<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleGroupeEnseignant extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'groupe_id', 'enseignant_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function examens()
    {
        return $this->hasMany(Examen::class, 'module_groupe_enseignant_id');
    }
}
