<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class AccountCredenziale extends Model
{
    use SoftDeletes;

    protected $table = 'account_credenziali';

    protected $fillable = [
        'cliente_id', 'tipo', 'url', 'username', 'password_enc', 'note',
    ];

    // Password mai esposta in array/json
    protected $hidden = ['password_enc'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Setter: cifra automaticamente la password prima di salvarla
    public function setPasswordEncAttribute(string $value): void
    {
        $this->attributes['password_enc'] = Crypt::encryptString($value);
    }

    // Getter: decifra automaticamente al recupero
    public function getPasswordEncAttribute(string $value): string
    {
        return Crypt::decryptString($value);
    }
}
