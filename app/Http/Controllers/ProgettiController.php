<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Progetto;
use App\Models\RataPagamento;
use App\Models\StepProgetto;
use Illuminate\Http\Request;

class ProgettiController extends Controller
{
    /* ─────────────────────────── PROGETTI ─────────────────────────── */

    public function index(Request $request)
    {
        $query = Progetto::with('cliente')->withTrashed(false);

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('stato')) {
            $query->where('stato', $request->stato);
        }
        if ($request->filled('q')) {
            $query->where('titolo', 'like', '%' . $request->q . '%');
        }

        $progetti = $query->orderByDesc('created_at')->paginate(25)->withQueryString();
        $clienti  = Cliente::orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);

        return view('progetti.index', compact('progetti', 'clienti'));
    }

    public function create()
    {
        $clienti = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        return view('progetti.create', compact('clienti'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'        => 'required|exists:clienti,id',
            'titolo'            => 'required|string|max:255',
            'descrizione'       => 'nullable|string',
            'importo_proposta'  => 'nullable|numeric|min:0',
            'valore_totale'     => 'nullable|numeric|min:0',
            'stato'             => 'required|in:bozza,offerta_inviata,accettato,in_corso,completato,annullato',
            'data_offerta'      => 'nullable|date',
            'data_accettazione' => 'nullable|date',
            'note'              => 'nullable|string',
        ]);

        $progetto = Progetto::create($data);

        return redirect()->route('progetti.show', $progetto)->with('success', 'Progetto creato.');
    }

    public function show(Progetto $progetto)
    {
        $progetto->load(['cliente', 'rate', 'step.rata']);
        return view('progetti.show', compact('progetto'));
    }

    public function edit(Progetto $progetto)
    {
        $clienti = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        return view('progetti.edit', compact('progetto', 'clienti'));
    }

    public function update(Request $request, Progetto $progetto)
    {
        $data = $request->validate([
            'cliente_id'        => 'required|exists:clienti,id',
            'titolo'            => 'required|string|max:255',
            'descrizione'       => 'nullable|string',
            'importo_proposta'  => 'nullable|numeric|min:0',
            'valore_totale'     => 'nullable|numeric|min:0',
            'stato'             => 'required|in:bozza,offerta_inviata,accettato,in_corso,completato,annullato',
            'data_offerta'      => 'nullable|date',
            'data_accettazione' => 'nullable|date',
            'note'              => 'nullable|string',
        ]);

        $progetto->update($data);

        return redirect()->route('progetti.show', $progetto)->with('success', 'Progetto aggiornato.');
    }

    public function destroy(Progetto $progetto)
    {
        $progetto->delete();
        return redirect()->route('progetti.index')->with('success', 'Progetto eliminato.');
    }

    /* ─────────────────────────── RATE ─────────────────────────── */

    public function storeRata(Request $request, Progetto $progetto)
    {
        $data = $request->validate([
            'descrizione'   => 'required|string|max:255',
            'percentuale'   => 'nullable|numeric|min:0|max:100',
            'importo'       => 'required|numeric|min:0',
            'data_prevista' => 'nullable|date',
            'stato'         => 'required|in:attesa,incassata,in_ritardo',
        ]);

        $numero = $progetto->rate()->max('numero_rata') + 1;

        $progetto->rate()->create([
            'numero_rata'   => $numero,
            'descrizione'   => $data['descrizione'],
            'percentuale'   => $data['percentuale'] ?? 0,
            'importo'       => $data['importo'],
            'data_prevista' => $data['data_prevista'] ?? null,
            'stato'         => $data['stato'],
        ]);

        return redirect()->route('progetti.show', $progetto)->with('success', 'Rata aggiunta.');
    }

    public function updateRata(Request $request, Progetto $progetto, RataPagamento $rata)
    {
        abort_if($rata->progetto_id !== $progetto->id, 403);

        $data = $request->validate([
            'descrizione'   => 'required|string|max:255',
            'percentuale'   => 'nullable|numeric|min:0|max:100',
            'importo'       => 'required|numeric|min:0',
            'data_prevista' => 'nullable|date',
            'data_incasso'  => 'nullable|date',
            'stato'         => 'required|in:attesa,incassata,in_ritardo',
        ]);

        $rata->update($data);

        return redirect()->route('progetti.show', $progetto)->with('success', 'Rata aggiornata.');
    }

    public function destroyRata(Progetto $progetto, RataPagamento $rata)
    {
        abort_if($rata->progetto_id !== $progetto->id, 403);
        $rata->delete();
        return redirect()->route('progetti.show', $progetto)->with('success', 'Rata eliminata.');
    }

    /* ─────────────────────────── STEP ─────────────────────────── */

    public function storeStep(Request $request, Progetto $progetto)
    {
        $data = $request->validate([
            'titolo'        => 'required|string|max:255',
            'descrizione'   => 'nullable|string',
            'rata_id'       => 'nullable|exists:rate_pagamento,id',
            'stato'         => 'required|in:da_fare,in_corso,completato',
            'data_prevista' => 'nullable|date',
        ]);

        $ordine = $progetto->step()->max('ordine') + 1;

        $progetto->step()->create(array_merge($data, ['ordine' => $ordine]));

        return redirect()->route('progetti.show', $progetto)->with('success', 'Step aggiunto.');
    }

    public function updateStep(Request $request, Progetto $progetto, StepProgetto $step)
    {
        abort_if($step->progetto_id !== $progetto->id, 403);

        $data = $request->validate([
            'titolo'             => 'required|string|max:255',
            'descrizione'        => 'nullable|string',
            'rata_id'            => 'nullable|exists:rate_pagamento,id',
            'stato'              => 'required|in:da_fare,in_corso,completato',
            'data_prevista'      => 'nullable|date',
            'data_completamento' => 'nullable|date',
        ]);

        $step->update($data);

        return redirect()->route('progetti.show', $progetto)->with('success', 'Step aggiornato.');
    }

    public function destroyStep(Progetto $progetto, StepProgetto $step)
    {
        abort_if($step->progetto_id !== $progetto->id, 403);
        $step->delete();
        return redirect()->route('progetti.show', $progetto)->with('success', 'Step eliminato.');
    }
}
