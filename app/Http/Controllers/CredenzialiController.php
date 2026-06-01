<?php

namespace App\Http\Controllers;

use App\Models\AccountCredenziale;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CredenzialiController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountCredenziale::with('cliente');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('url', 'like', '%'.$request->q.'%')
                  ->orWhere('username', 'like', '%'.$request->q.'%')
                  ->orWhere('note', 'like', '%'.$request->q.'%');
            });
        }
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $credenziali = $query->orderBy('cliente_id')->paginate(30)->withQueryString();
        $clienti     = Cliente::orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);

        return view('credenziali.index', compact('credenziali', 'clienti'));
    }

    public function create()
    {
        $clienti = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        return view('credenziali.create', compact('clienti'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id'   => 'required|exists:clienti,id',
            'tipo'         => 'required|string|max:50',
            'url'          => 'nullable|string|max:500',
            'username'     => 'required|string|max:255',
            'password_enc' => 'required|string',
            'note'         => 'nullable|string',
        ]);
        AccountCredenziale::create($data);
        return redirect()->route('credenziali.index')->with('success', 'Credenziale aggiunta.');
    }

    public function edit(AccountCredenziale $credenziale)
    {
        // Decifra per mostrare nel form
        try {
            $passwordChiara = Crypt::decryptString($credenziale->getRawOriginal('password_enc'));
        } catch (\Exception $e) {
            $passwordChiara = '';
        }
        $clienti = Cliente::where('attivo', true)->orderBy('ragione_sociale')->get(['id', 'ragione_sociale']);
        return view('credenziali.edit', compact('credenziale', 'clienti', 'passwordChiara'));
    }

    public function update(Request $request, AccountCredenziale $credenziale)
    {
        $data = $request->validate([
            'cliente_id'   => 'required|exists:clienti,id',
            'tipo'         => 'required|string|max:50',
            'url'          => 'nullable|string|max:500',
            'username'     => 'required|string|max:255',
            'password_enc' => 'nullable|string',
            'note'         => 'nullable|string',
        ]);

        if (empty($data['password_enc'])) {
            unset($data['password_enc']);
        }

        $credenziale->update($data);
        return redirect()->route('credenziali.index')->with('success', 'Credenziale aggiornata.');
    }

    public function destroy(AccountCredenziale $credenziale)
    {
        $credenziale->delete();
        return redirect()->back()->with('success', 'Credenziale eliminata.');
    }

    public function mostraPassword(AccountCredenziale $credenziale)
    {
        try {
            $pwd = Crypt::decryptString($credenziale->getRawOriginal('password_enc'));
        } catch (\Exception $e) {
            $pwd = '(errore decifratura)';
        }
        return response()->json(['password' => $pwd]);
    }
}
