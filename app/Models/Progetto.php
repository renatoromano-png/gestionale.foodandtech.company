<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Progetto extends Model
{
    use SoftDeletes;

    protected $table = 'progetti';

    protected $fillable = [
        'cliente_id', 'titolo', 'descrizione', 'valore_totale', 'importo_proposta', 'stato',
        'data_offerta', 'data_accettazione', 'allegato_path', 'note',
    ];

    protected $casts = [
        'valore_totale'    => 'decimal:2',
        'importo_proposta' => 'decimal:2',
        'data_offerta'     => 'date',
        'data_accettazione'=> 'date',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function rate(): HasMany
    {
        return $this->hasMany(RataPagamento::class, 'progetto_id')->orderBy('numero_rata');
    }

    public function step(): HasMany
    {
        return $this->hasMany(StepProgetto::class, 'progetto_id')->orderBy('ordine');
    }

    // Ricalcola gli importi delle rate in base al valore totale
    public function ricalcolaRate(): void
    {
        foreach ($this->rate as $rata) {
            $rata->update([
                'importo' => round($this->valore_totale * $rata->percentuale / 100, 2),
            ]);
        }
    }
}
