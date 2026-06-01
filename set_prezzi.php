<?php
require __DIR__.'/laravel_setup/vendor/autoload.php';
$app = require __DIR__.'/laravel_setup/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// ── 1. Prezzi articoli per tipologia ─────────────────────────────────────────
$prezziTipologie = [
    'PEC'          => 35.00,
    'PEC dominio'  => 15.00,
    'Hosting'      => 80.00,
    'VPS'          => 120.00,
    'SSL'          => 50.00,
    'Manutenzione' => 200.00,
];

foreach ($prezziTipologie as $nomeTip => $prezzo) {
    $tid = DB::table('tipologie_scadenza')->where('nome', $nomeTip)->value('id');
    if (!$tid) { echo "Tipologia non trovata: $nomeTip\n"; continue; }

    $n = DB::table('articoli')
        ->where('tipologia_id', $tid)
        ->whereNull('deleted_at')
        ->where(function($q){ $q->whereNull('prezzo')->orWhere('prezzo', 0); })
        ->update(['prezzo' => $prezzo, 'updated_at' => now()]);

    echo "  $nomeTip → €$prezzo — aggiornati $n articoli\n";
}

// ── 2. Prezzi domini per TLD ──────────────────────────────────────────────────
$prezziTld = [
    '.it'      => 25.00,
    '.com'     => 30.00,
    '.eu'      => 20.00,
    '.net'     => 28.00,
    '.org'     => 25.00,
    '.biz'     => 28.00,
    '.info'    => 20.00,
    '.shop'    => 35.00,
    '.consulting' => 40.00,
    '.company' => 40.00,
    '.site'    => 20.00,
    '.ca'      => 30.00,
];

$domini = DB::table('domini')
    ->whereNull('deleted_at')
    ->where(function($q){ $q->whereNull('prezzo')->orWhere('prezzo', 0); })
    ->get(['id', 'dominio']);

$aggiornati = 0;
foreach ($domini as $d) {
    $prezzo = null;
    foreach ($prezziTld as $tld => $p) {
        if (str_ends_with($d->dominio, $tld)) {
            $prezzo = $p;
            break;
        }
    }
    if ($prezzo === null) { echo "  TLD sconosciuto: {$d->dominio}\n"; continue; }

    DB::table('domini')->where('id', $d->id)->update([
        'prezzo'     => $prezzo,
        'updated_at' => now(),
    ]);
    $aggiornati++;
}

echo "\nDomini aggiornati con prezzo: $aggiornati\n";
echo "Fine.\n";
