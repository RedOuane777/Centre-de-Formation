<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code_etud',
        'ville',
        'date_naissance',
        'filiere_id',
        'groupe_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id', 'id');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id', 'id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'etudiant_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'etudiant_id', 'id');
    }
}