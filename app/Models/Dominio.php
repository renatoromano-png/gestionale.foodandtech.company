<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dominio extends Model
{
    use SoftDeletes;

    protected $table = 'domini';

    protected $fillable = [
        'cliente_id', 'dominio', 'solo_dns',
        'data_registrazione', 'data_inizio_mantenimento',
        'data_scadenza', 'prezzo',
        'registrar', 'note',
    ];

    protected $casts = [
        'solo_dns'                 => 'boolean',
        'data_registrazione'       => 'date',
        'data_inizio_mantenimento' => 'date',
        'data_scadenza'            => 'date',
        'prezzo'                   => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
