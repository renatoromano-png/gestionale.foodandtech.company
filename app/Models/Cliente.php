<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clienti';

    protected $fillable = [
        'codice', 'ragione_sociale', 'indirizzo', 'cap', 'citta',
        'provincia', 'email', 'pec', 'codice_sdi', 'telefono', 'attivo', 'note',
    ];

    protected $casts = ['attivo' => 'boolean'];

    public function articoli(): HasMany
    {
        return $this->hasMany(Articolo::class, 'cliente_id');
    }

    public function domini(): HasMany
    {
        return $this->hasMany(Dominio::class, 'cliente_id');
    }

    public function credenziali(): HasMany
    {
        return $this->hasMany(AccountCredenziale::class, 'cliente_id');
    }

    public function progetti(): HasMany
    {
        return $this->hasMany(Progetto::class, 'cliente_id');
    }
}
