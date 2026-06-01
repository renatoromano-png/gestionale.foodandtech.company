@extends('layouts.app')
@section('title', 'Modifica Scadenza')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('scadenze.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0">Modifica Scadenza — {{ $scadenza->articolo->cliente->ragione_sociale }}</h5>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('scadenze.update', $scadenza) }}">
            @csrf @method('PUT')
            @include('scadenze._form')
            <div class="mb-3">
                <label class="form-label small fw-semibold">Stato</label>
                <select name="stato" class="form-select">
                    <option value="attiva"     {{ old('stato', $scadenza->stato) == 'attiva'     ? 'selected' : '' }}>Attiva</option>
                    <option value="rinnovata"  {{ old('stato', $scadenza->stato) == 'rinnovata'  ? 'selected' : '' }}>Rinnovata</option>
                    <option value="cancellata" {{ old('stato', $scadenza->stato) == 'cancellata' ? 'selected' : '' }}>Cancellata</option>
                </select>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Aggiorna</button>
                <a href="{{ route('scadenze.index') }}" class="btn btn-outline-secondary">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection
