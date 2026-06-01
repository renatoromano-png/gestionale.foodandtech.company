<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StepProgetto extends Model
{
    protected $table = 'step_progetto';

    protected $fillable = [
        'progetto_id', 'rata_id', 'titolo', 'descrizione',
        'ordine', 'stato', 'data_prevista', 'data_completamento',
    ];

    protected $casts = [
        'data_prevista'      => 'date',
        'data_completamento' => 'date',
    ];

    public function progetto(): BelongsTo
    {
        return $this->belongsTo(Progetto::class, 'progetto_id');
    }

    public function rata(): BelongsTo
    {
        return $this->belongsTo(RataPagamento::class, 'rata_id');
    }
}
