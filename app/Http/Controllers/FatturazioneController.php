<?php

namespace App\Http\Controllers;

use App\Models\Articolo;
use App\Models\Dominio;
use App\Models\RataPagamento;
use App\Models\Scadenza;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FatturazioneController extends Controller
{
    public function index(Request $request)
    {
        $anno = (int) $request->get('anno', now()->year);
        $mese = (int) $request->get('mese', now()->month);

        $inizio = Carbon::create($anno, $mese, 1)->startOfMonth();
        $fine   = $inizio->copy()->endOfMonth();

        // 1. Articoli mensili attivi (sempre fatturati ogni mese)
        $mensili = Articolo::with(['cliente', 'tipologia'])
            ->whereHas('tipologia', fn($q) => $q->where('periodicita', 'mensile'))
            ->where('attivo', true)
            ->whereNull('deleted_at')
            ->get()
            ->map(fn($a) => [
                'cliente'     => $a->cliente->ragione_sociale,
                'descrizione' => $a->descrizione,
                'tipologia'   => $a->tipologia->nome ?? '—',
                'periodicita' => 'mensile',
                'prezzo'      => $a->prezzo,
                'scadenza'    => null,
                'articolo_id' => $a->id,
            ]);

        // 2. Scadenze non-mensili che cadono nel mese selezionato
        $scadenze = Scadenza::with(['articolo.cliente', 'articolo.tipologia'])
            ->whereBetween('data_scadenza', [$inizio, $fine])
            ->where('stato', 'attiva')
            ->whereHas('articolo.tipologia', fn($q) => $q->where('periodicita', '!=', 'mensile'))
            ->get()
            ->map(fn($s) => [
                'cliente'     => $s->articolo->cliente->ragione_sociale ?? '—',
                'descrizione' => $s->articolo->descrizione,
                'tipologia'   => $s->articolo->tipologia->nome ?? '—',
                'periodicita' => $s->articolo->tipologia->periodicita ?? '—',
                'prezzo'      => $s->articolo->prezzo,
                'scadenza'    => $s->data_scadenza->format('d/m/Y'),
                'articolo_id' => $s->articolo_id,
            ]);

        // 3. Domini con data_scadenza nel mese selezionato
        $domini = Dominio::with('cliente')
            ->whereBetween('data_scadenza', [$inizio, $fine])
            ->whereNull('deleted_at')
            ->get()
            ->map(fn($d) => [
                'cliente'     => $d->cliente->ragione_sociale ?? '—',
                'descrizione' => $d->dominio,
                'tipologia'   => 'Dominio',
                'periodicita' => 'annuale',
                'prezzo'      => $d->prezzo ?? 0,
                'scadenza'    => $d->data_scadenza ? \Carbon\Carbon::parse($d->data_scadenza)->format('d/m/Y') : null,
                'articolo_id' => null,
            ]);

        // 4. Rate di progetto con data_prevista nel mese selezionato
        $rateProgetti = RataPagamento::with(['progetto.cliente'])
            ->whereBetween('data_prevista', [$inizio, $fine])
            ->whereIn('stato', ['attesa', 'in_ritardo'])
            ->whereHas('progetto', fn($q) => $q->whereNull('deleted_at')
                ->whereNotIn('stato', ['annullato']))
            ->get()
            ->map(fn($r) => [
                'cliente'     => $r->progetto->cliente->ragione_sociale ?? '—',
                'descrizione' => $r->progetto->titolo.' — '.$r->descrizione,
                'tipologia'   => 'Progetto',
                'periodicita' => 'progetto',
                'prezzo'      => $r->importo,
                'scadenza'    => $r->data_prevista->format('d/m/Y'),
                'articolo_id' => null,
            ]);

        // Unione e ordinamento per cliente
        $voci = $mensili->concat($scadenze)->concat($domini)->concat($rateProgetti)
            ->sortBy('cliente')
            ->values();

        $totale = $voci->sum('prezzo');

        // Anni disponibili per il selettore (dal 2024 al prossimo anno)
        $anni = range(2024, now()->addYear()->year);

        $mesi = [
            1=>'Gennaio', 2=>'Febbraio', 3=>'Marzo', 4=>'Aprile',
            5=>'Maggio', 6=>'Giugno', 7=>'Luglio', 8=>'Agosto',
            9=>'Settembre', 10=>'Ottobre', 11=>'Novembre', 12=>'Dicembre',
        ];

        return view('fatturazione.index', compact('voci', 'totale', 'anno', 'mese', 'anni', 'mesi'));
    }
}
