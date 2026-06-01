<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'utenti';

    protected $fillable = ['nome', 'email', 'password', 'ruolo', 'attivo'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'attivo'     => 'boolean',
        'last_login' => 'datetime',
    ];
}
