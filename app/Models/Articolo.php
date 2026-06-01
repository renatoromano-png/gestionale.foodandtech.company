<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Articolo extends Model
{
    use SoftDeletes;

    protected $table = 'articoli';

    protected $fillable = [
        'cliente_id', 'tipologia_id', 'descrizione', 'prezzo', 'attivo', 'note',
    ];

    protected $casts = [
        'prezzo' => 'decimal:2',
        'attivo' => 'boolean',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function tipologia(): BelongsTo
    {
        return $this->belongsTo(TipologiaScadenza::class, 'tipologia_id');
    }

    public function scadenze(): HasMany
    {
        return $this->hasMany(Scadenza::class, 'articolo_id');
    }

    public function prossima_scadenza(): ?Scadenza
    {
        return $this->scadenze()
            ->where('stato', 'attiva')
            ->where('data_scadenza', '>=', now())
            ->orderBy('data_scadenza')
            ->first();
    }
}
