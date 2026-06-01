<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipologiaScadenza extends Model
{
    protected $table = 'tipologie_scadenza';

    protected $fillable = [
        'nome', 'descrizione', 'colore', 'prezzo_default', 'periodicita', 'attivo',
    ];

    protected $casts = [
        'attivo'          => 'boolean',
        'prezzo_default'  => 'decimal:2',
    ];

    public function articoli(): HasMany
    {
        return $this->hasMany(Articolo::class, 'tipologia_id');
    }
}
