<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModuleGroupeEnseignant;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salaire',
        'date_naissance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moduleGroupeEnseignants()
    {
        return $this->hasMany(ModuleGroupeEnseignant::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
