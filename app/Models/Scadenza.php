<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scadenza extends Model
{
    protected $table = 'scadenze';

    protected $fillable = [
        'articolo_id', 'data_scadenza', 'stato', 'note',
    ];

    protected $casts = [
        'data_scadenza' => 'date',
    ];

    public function articolo(): BelongsTo
    {
        return $this->belongsTo(Articolo::class, 'articolo_id');
    }

    // Scadenza entro X giorni (utile per alert)
    public function scadeEntro(int $giorni = 30): bool
    {
        return $this->data_scadenza->lte(now()->addDays($giorni));
    }
}
