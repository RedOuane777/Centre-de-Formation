<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'examen_id',
        'noteE',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id');
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id', 'id');
    }
}