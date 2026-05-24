<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'gender',
        'reset_code',
        'reset_code_expires_at',
        'reset_attempts',
        'reset_token',
        'reset_token_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'reset_code_expires_at' => 'datetime',
            'reset_token_expires_at' => 'datetime',
        ];
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'user_id', 'id');
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class, 'user_id', 'id');
    }
}
