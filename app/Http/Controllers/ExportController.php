<?php

namespace App\Http\Controllers;

use App\Models\Articolo;
use App\Models\Cliente;
use App\Models\Scadenza;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExportController extends Controller
{
    public function clienti()
    {
        $clienti = Cliente::orderBy('ragione_sociale')->get();
        $filename = 'clienti_' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($clienti) {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
            fputcsv($f, ['Codice','Ragione Sociale','Email','Telefono','Città','Attivo']);
            foreach ($clienti as $c) {
                fputcsv($f, [$c->codice, $c->ragione_sociale, $c->email, $c->telefono, $c->citta, $c->attivo ? 'Sì' : 'No']);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function scadenze(Request $request)
    {
        $query = Scadenza::with(['articolo.cliente', 'articolo.tipologia'])
            ->join('articoli', 'articoli.id', '=', 'scadenze.articolo_id')
            ->select('scadenze.*')
            ->where('scadenze.stato', 'attiva')
            ->orderBy('scadenze.data_scadenza');

        if ($request->filled('cliente_id')) {
            $query->where('articoli.cliente_id', $request->cliente_id);
        }

        $scadenze = $query->get();
        $filename = 'scadenze_' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($scadenze) {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($f, ['Cliente','Descrizione','Tipologia','Periodicità','Data Scadenza','Stato']);
            foreach ($scadenze as $s) {
                fputcsv($f, [
                    $s->articolo->cliente->ragione_sociale ?? '',
                    $s->articolo->descrizione ?? '',
                    $s->articolo->tipologia->nome ?? '',
                    $s->articolo->tipologia->periodicita ?? '',
                    $s->data_scadenza?->format('d/m/Y'),
                    $s->stato,
                ]);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function fatturazione(Request $request)
    {
        $anno   = (int) $request->get('anno', now()->year);
        $mese   = (int) $request->get('mese', now()->month);
        $inizio = Carbon::create($anno, $mese, 1)->startOfMonth();
        $fine   = $inizio->copy()->endOfMonth();

        $mensili = Articolo::with(['cliente', 'tipologia'])
            ->whereHas('tipologia', fn($q) => $q->where('periodicita', 'mensile'))
            ->where('attivo', true)->whereNull('deleted_at')->get()
            ->map(fn($a) => [
                $a->cliente->ragione_sociale, $a->descrizione,
                $a->tipologia->nome ?? '', 'mensile', $a->prezzo, '',
            ]);

        $scadenze = Scadenza::with(['articolo.cliente', 'articolo.tipologia'])
            ->whereBetween('data_scadenza', [$inizio, $fine])
            ->where('stato', 'attiva')
            ->whereHas('articolo.tipologia', fn($q) => $q->where('periodicita', '!=', 'mensile'))
            ->get()
            ->map(fn($s) => [
                $s->articolo->cliente->ragione_sociale ?? '',
                $s->articolo->descrizione,
                $s->articolo->tipologia->nome ?? '',
                $s->articolo->tipologia->periodicita ?? '',
                $s->articolo->prezzo,
                $s->data_scadenza->format('d/m/Y'),
            ]);

        $voci     = $mensili->concat($scadenze)->sortBy(fn($v) => $v[0]);
        $filename = "fatturazione_{$anno}_{$mese}.csv";
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($voci) {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($f, ['Cliente','Descrizione','Tipologia','Periodicità','Prezzo €','Scadenza']);
            foreach ($voci as $v) { fputcsv($f, $v); }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }
}
