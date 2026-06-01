<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientiController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::withCount(['articoli', 'domini', 'credenziali', 'progetti'])
            ->withExists([
                'articoli as ha_scadenze_urgenti' => function ($q) {
                    $q->whereHas('scadenze', fn($s) =>
                        $s->where('stato', 'attiva')
                          ->where('data_scadenza', '<=', now()->addDays(30))
                    );
                },
                'articoli as ha_scadenze_scadute' => function ($q) {
                    $q->whereHas('scadenze', fn($s) =>
                        $s->where('stato', 'attiva')
                          ->where('data_scadenza', '<', now())
                    );
                },
            ]);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('ragione_sociale', 'like', '%'.$request->q.'%')
                  ->orWhere('codice', 'like', '%'.$request->q.'%')
                  ->orWhere('email', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('stato')) {
            $query->where('attivo', $request->stato === 'attivo');
        }

        $clienti = $query->orderBy('ragione_sociale')->paginate(25)->withQueryString();

        return view('clienti.index', compact('clienti'));
    }

    public function show(Cliente $cliente)
    {
        $cliente->load([
            'articoli.tipologia',
            'articoli.scadenze' => fn($q) => $q->where('stato', 'attiva')->orderBy('data_scadenza'),
            'domini',
            'credenziali',
            'progetti.rate',
            'progetti.step',
        ]);
        return view('clienti.show', compact('cliente'));
    }

    public function create()
    {
        return view('clienti.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ragione_sociale' => 'required|string|max:255',
            'codice'          => 'nullable|string|max:20|unique:clienti,codice',
            'indirizzo'       => 'nullable|string|max:255',
            'cap'             => 'nullable|string|max:10',
            'citta'           => 'nullable|string|max:100',
            'provincia'       => 'nullable|string|max:5',
            'email'           => 'nullable|email|max:255',
            'telefono'        => 'nullable|string|max:50',
            'note'            => 'nullable|string',
            'attivo'          => 'boolean',
        ]);
        $data['attivo'] = $request->boolean('attivo', true);
        $cliente = Cliente::create($data);
        return redirect()->route('clienti.show', $cliente)->with('success', 'Cliente creato con successo.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clienti.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'ragione_sociale' => 'required|string|max:255',
            'codice'          => 'nullable|string|max:20|unique:clienti,codice,'.$cliente->id,
            'indirizzo'       => 'nullable|string|max:255',
            'cap'             => 'nullable|string|max:10',
            'citta'           => 'nullable|string|max:100',
            'provincia'       => 'nullable|string|max:5',
            'email'           => 'nullable|email|max:255',
            'telefono'        => 'nullable|string|max:50',
            'note'            => 'nullable|string',
            'attivo'          => 'boolean',
        ]);
        $data['attivo'] = $request->boolean('attivo');
        $cliente->update($data);
        return redirect()->route('clienti.show', $cliente)->with('success', 'Cliente aggiornato.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clienti.index')->with('success', 'Cliente eliminato.');
    }
}
