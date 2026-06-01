@extends('layouts.app')
@section('title', 'Modifica Cliente')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('clienti.show', $cliente) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0">Modifica — {{ $cliente->ragione_sociale }}</h5>
</div>
<div class="card" style="max-width:700px">
    <div class="card-body">
        <form method="POST" action="{{ route('clienti.update', $cliente) }}">
            @csrf @method('PUT')
            @include('clienti._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Aggiorna</button>
                <a href="{{ route('clienti.show', $cliente) }}" class="btn btn-outline-secondary">Annulla</a>
            </div>
        </form>
        <hr>
        <form method="POST" action="{{ route('clienti.destroy', $cliente) }}" onsubmit="return confirm('Eliminare il cliente?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Elimina cliente</button>
        </form>
    </div>
</div>
@endsection
