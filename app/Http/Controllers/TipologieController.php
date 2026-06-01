<?php

namespace App\Http\Controllers;

use App\Models\Articolo;
use App\Models\TipologiaScadenza;
use Illuminate\Http\Request;

class TipologieController extends Controller
{
    public function index()
    {
        $tipologie = TipologiaScadenza::orderBy('nome')->get();
        return view('impostazioni.tipologie', compact('tipologie'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'          => 'required|string|max:100|unique:tipologie_scadenza,nome',
            'descrizione'   => 'nullable|string',
            'colore'        => 'required|string|max:7',
            'prezzo_default'=> 'nullable|numeric|min:0',
            'periodicita'   => 'required|in:mensile,trimestrale,semestrale,annuale,biennale',
            'attivo'        => 'boolean',
        ]);
        $data['attivo'] = $request->boolean('attivo', true);
        TipologiaScadenza::create($data);
        return redirect()->route('tipologie.index')->with('success', 'Tipologia aggiunta.');
    }

    public function update(Request $request, TipologiaScadenza $tipologia)
    {
        $data = $request->validate([
            'nome'          => 'required|string|max:100|unique:tipologie_scadenza,nome,'.$tipologia->id,
            'descrizione'   => 'nullable|string',
            'colore'        => 'required|string|max:7',
            'prezzo_default'=> 'nullable|numeric|min:0',
            'periodicita'   => 'required|in:mensile,trimestrale,semestrale,annuale,biennale',
            'attivo'        => 'boolean',
        ]);
        $data['attivo'] = $request->boolean('attivo');

        // Leggo il nuovo prezzo PRIMA di fare update (il cast decimal può restituire string, uso floatval)
        $nuovoPrezzo = array_key_exists('prezzo_default', $data) && $data['prezzo_default'] !== null
            ? floatval($data['prezzo_default'])
            : null;

        $tipologia->update($data);

        // Propaga il nuovo prezzo a TUTTI gli articoli associati a questa tipologia
        $aggiornati = 0;
        if ($nuovoPrezzo !== null) {
            $aggiornati = Articolo::where('tipologia_id', $tipologia->id)
                ->whereNull('deleted_at')
                ->update(['prezzo' => $nuovoPrezzo]);
        }

        $msg = $aggiornati > 0
            ? "Tipologia aggiornata. Prezzo (€ ".number_format($nuovoPrezzo, 2, ',', '.')." ) propagato a {$aggiornati} ".($aggiornati === 1 ? 'articolo' : 'articoli').'.'
            : 'Tipologia aggiornata.';

        return redirect()->route('tipologie.index')->with('success', $msg);
    }

    public function destroy(TipologiaScadenza $tipologia)
    {
        $tipologia->delete();
        return redirect()->route('tipologie.index')->with('success', 'Tipologia eliminata.');
    }
}
