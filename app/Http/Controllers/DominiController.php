<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Dominio;
use Illuminate\Http\Request;

class DominiController extends Controller
{
    public function index(Request $request)
    {
        $query = Dominio::with('cliente');

        if ($request->filled('q')) {
            $query->where('dominio', 'like', '%'.$request->q.'%');
        }
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('solo_dns')) {
            $query->where('solo_dns', $request->solo_dns === '1');
        }

        $domini  = $query->orderByRaw('data_scadenza IS NULL ASC')->orderBy('data_scadenza')->paginate(30)->withQueryString();
        $clienti = Cliente::orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);

        return view('domini.index', compact('domini', 'clienti'));
    }

    public function create()
    {
        $clienti = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        return view('domini.create', compact('clienti'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'               => 'required|exists:clienti,id',
            'dominio'                  => 'required|string|max:255',
            'solo_dns'                 => 'boolean',
            'data_registrazione'       => 'nullable|date',
            'data_inizio_mantenimento' => 'nullable|date',
            'data_scadenza'            => 'nullable|date',
            'prezzo'                   => 'nullable|numeric|min:0',
            'registrar'                => 'nullable|string|max:100',
            'note'                     => 'nullable|string',
        ]);
        $data['solo_dns'] = $request->boolean('solo_dns');
        Dominio::create($data);
        return redirect()->route('domini.index')->with('success', 'Dominio aggiunto.');
    }

    public function edit(Dominio $dominio)
    {
        $clienti = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        return view('domini.edit', compact('dominio', 'clienti'));
    }

    public function update(Request $request, Dominio $dominio)
    {
        $data = $request->validate([
            'cliente_id'               => 'required|exists:clienti,id',
            'dominio'                  => 'required|string|max:255',
            'solo_dns'                 => 'boolean',
            'data_registrazione'       => 'nullable|date',
            'data_inizio_mantenimento' => 'nullable|date',
            'data_scadenza'            => 'nullable|date',
            'prezzo'                   => 'nullable|numeric|min:0',
            'registrar'                => 'nullable|string|max:100',
            'note'                     => 'nullable|string',
        ]);
        $data['solo_dns'] = $request->boolean('solo_dns');
        $dominio->update($data);
        return redirect()->route('domini.index')->with('success', 'Dominio aggiornato.');
    }

    public function destroy(Dominio $dominio)
    {
        $dominio->delete();
        return redirect()->back()->with('success', 'Dominio eliminato.');
    }
}
