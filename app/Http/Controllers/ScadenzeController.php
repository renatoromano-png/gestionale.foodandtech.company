<?php

namespace App\Http\Controllers;

use App\Models\Articolo;
use App\Models\Cliente;
use App\Models\Scadenza;
use App\Models\TipologiaScadenza;
use Illuminate\Http\Request;

class ScadenzeController extends Controller
{
    public function index(Request $request)
    {
        $query = Scadenza::with(['articolo.cliente', 'articolo.tipologia'])
            ->join('articoli', 'articoli.id', '=', 'scadenze.articolo_id')
            ->join('clienti', 'clienti.id', '=', 'articoli.cliente_id')
            ->whereNull('articoli.deleted_at')
            ->whereNull('clienti.deleted_at')
            ->select('scadenze.*');

        if ($request->filled('cliente_id')) {
            $query->where('articoli.cliente_id', $request->cliente_id);
        }
        if ($request->filled('tipologia_id')) {
            $query->where('articoli.tipologia_id', $request->tipologia_id);
        }
        if ($request->filled('stato')) {
            $query->where('scadenze.stato', $request->stato);
        } else {
            $query->where('scadenze.stato', 'attiva');
        }
        if ($request->filled('periodo')) {
            match ($request->periodo) {
                'scadute'  => $query->where('scadenze.data_scadenza', '<', now()),
                '30gg'     => $query->whereBetween('scadenze.data_scadenza', [now(), now()->addDays(30)]),
                '60gg'     => $query->whereBetween('scadenze.data_scadenza', [now(), now()->addDays(60)]),
                '90gg'     => $query->whereBetween('scadenze.data_scadenza', [now(), now()->addDays(90)]),
                default    => null,
            };
        }

        $scadenze  = $query->orderBy('scadenze.data_scadenza')->paginate(30)->withQueryString();
        $clienti   = Cliente::orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        $tipologie = TipologiaScadenza::where('attivo', true)->orderBy('nome')->get(['id', 'nome']);

        return view('scadenze.index', compact('scadenze', 'clienti', 'tipologie'));
    }

    public function create()
    {
        $clienti   = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        $tipologie = TipologiaScadenza::where('attivo', true)->orderBy('nome')->get();
        return view('scadenze.create', compact('clienti', 'tipologie'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'    => 'required|exists:clienti,id',
            'tipologia_id'  => 'nullable|exists:tipologie_scadenza,id',
            'descrizione'   => 'required|string|max:255',
            'prezzo'        => 'nullable|numeric|min:0',
            'data_scadenza' => 'required|date',
            'note'          => 'nullable|string',
        ]);

        $articolo = Articolo::create([
            'cliente_id'   => $data['cliente_id'],
            'tipologia_id' => $data['tipologia_id'] ?? null,
            'descrizione'  => $data['descrizione'],
            'prezzo'       => $data['prezzo'] ?? null,
            'attivo'       => true,
        ]);

        Scadenza::create([
            'articolo_id'   => $articolo->id,
            'data_scadenza' => $data['data_scadenza'],
            'stato'         => 'attiva',
            'note'          => $data['note'] ?? null,
        ]);

        return redirect()->route('scadenze.index')->with('success', 'Scadenza aggiunta con successo.');
    }

    public function edit(Scadenza $scadenza)
    {
        $scadenza->load('articolo.cliente', 'articolo.tipologia');
        $clienti   = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        $tipologie = TipologiaScadenza::where('attivo', true)->orderBy('nome')->get();
        return view('scadenze.edit', compact('scadenza', 'clienti', 'tipologie'));
    }

    public function update(Request $request, Scadenza $scadenza)
    {
        $data = $request->validate([
            'tipologia_id'  => 'nullable|exists:tipologie_scadenza,id',
            'descrizione'   => 'required|string|max:255',
            'prezzo'        => 'nullable|numeric|min:0',
            'data_scadenza' => 'required|date',
            'stato'         => 'required|in:attiva,rinnovata,cancellata',
            'note'          => 'nullable|string',
        ]);

        $scadenza->articolo->update([
            'tipologia_id' => $data['tipologia_id'] ?? null,
            'descrizione'  => $data['descrizione'],
            'prezzo'       => $data['prezzo'] ?? null,
        ]);

        $scadenza->update([
            'data_scadenza' => $data['data_scadenza'],
            'stato'         => $data['stato'],
            'note'          => $data['note'] ?? null,
        ]);

        return redirect()->route('scadenze.index')->with('success', 'Scadenza aggiornata.');
    }

    public function destroy(Scadenza $scadenza)
    {
        $scadenza->articolo->delete();
        return redirect()->back()->with('success', 'Scadenza eliminata.');
    }

    public function rinnova(Request $request, Scadenza $scadenza)
    {
        $scadenza->load('articolo.tipologia');
        $periodicita = $scadenza->articolo->tipologia->periodicita ?? 'annuale';

        $nuovaData = match ($periodicita) {
            'mensile'     => $scadenza->data_scadenza->addMonth(),
            'trimestrale' => $scadenza->data_scadenza->addMonths(3),
            'biennale'    => $scadenza->data_scadenza->addYears(2),
            default       => $scadenza->data_scadenza->addYear(),
        };

        $scadenza->update(['stato' => 'rinnovata']);

        Scadenza::create([
            'articolo_id'   => $scadenza->articolo_id,
            'data_scadenza' => $nuovaData,
            'stato'         => 'attiva',
        ]);

        return redirect()->back()->with('success', 'Scadenza rinnovata fino al '.$nuovaData->format('d/m/Y').'.');
    }
}
