@extends('layouts.app')
@section('title', 'Modifica Dominio')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('domini.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0">Modifica — {{ $dominio->dominio }}</h5>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('domini.update', $dominio) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label small fw-semibold">Cliente *</label>
                <select name="cliente_id" class="form-select" required>
                    <option value="">Seleziona…</option>
                    @foreach($clienti as $c)
                        <option value="{{ $c->id }}" {{ old('cliente_id', $dominio->cliente_id) == $c->id ? 'selected' : '' }}>{{ $c->ragione_sociale }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Dominio *</label>
                <input type="text" name="dominio" class="form-control" required value="{{ old('dominio', $dominio->dominio) }}" placeholder="es. example.com">
            </div>
            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Data Registrazione</label>
                    <input type="date" name="data_registrazione" class="form-control" value="{{ old('data_registrazione', $dominio->data_registrazione?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Inizio Mantenimento</label>
                    <input type="date" name="data_inizio_mantenimento" class="form-control" value="{{ old('data_inizio_mantenimento', $dominio->data_inizio_mantenimento?->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Scadenza dominio</label>
                    <input type="date" name="data_scadenza" class="form-control" value="{{ old('data_scadenza', $dominio->data_scadenza?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Prezzo fatturato (€)</label>
                    <input type="number" step="0.01" name="prezzo" class="form-control" value="{{ old('prezzo', $dominio->prezzo) }}" placeholder="es. 15.00">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Registrar</label>
                <input type="text" name="registrar" class="form-control" value="{{ old('registrar', $dominio->registrar) }}">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="solo_dns" class="form-check-input" id="solo_dns" value="1" {{ old('solo_dns', $dominio->solo_dns ? '1' : '') == '1' ? 'checked' : '' }}>
                <label class="form-check-label small" for="solo_dns">Solo DNS (dominio puntato altrove)</label>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Note</label>
                <textarea name="note" class="form-control" rows="2">{{ old('note', $dominio->note) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Aggiorna</button>
                <a href="{{ route('domini.index') }}" class="btn btn-outline-secondary">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection
