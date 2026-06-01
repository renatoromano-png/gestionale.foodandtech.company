<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RataPagamento extends Model
{
    protected $table = 'rate_pagamento';

    protected $fillable = [
        'progetto_id', 'numero_rata', 'percentuale', 'importo',
        'data_prevista', 'data_incasso', 'stato', 'descrizione',
    ];

    protected $casts = [
        'percentuale'   => 'decimal:2',
        'importo'       => 'decimal:2',
        'data_prevista' => 'date',
        'data_incasso'  => 'date',
    ];

    public function progetto(): BelongsTo
    {
        return $this->belongsTo(Progetto::class, 'progetto_id');
    }

    public function step(): HasMany
    {
        return $this->hasMany(StepProgetto::class, 'rata_id');
    }
}
