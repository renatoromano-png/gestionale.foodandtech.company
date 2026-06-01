@extends('layouts.app')
@section('title', 'Modifica Progetto')
@section('content')

<div class="mb-3">
    <a href="{{ route('progetti.show', $progetto) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Torna al progetto
    </a>
</div>

<div class="card" style="max-width:720px">
    <div class="card-header bg-white fw-semibold">Modifica — {{ $progetto->titolo }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('progetti.update', $progetto) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label small fw-semibold">Cliente <span class="text-danger">*</span></label>
                <select name="cliente_id" class="form-select form-select-sm @error('cliente_id') is-invalid @enderror" required>
                    <option value="">— Seleziona cliente —</option>
                    @foreach($clienti as $c)
                        <option value="{{ $c->id }}" {{ old('cliente_id', $progetto->cliente_id) == $c->id ? 'selected' : '' }}>{{ $c->ragione_sociale }}</option>
                    @endforeach
                </select>
                @error('cliente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Titolo progetto <span class="text-danger">*</span></label>
                <input type="text" name="titolo" class="form-control form-control-sm @error('titolo') is-invalid @enderror"
                       value="{{ old('titolo', $progetto->titolo) }}" required>
                @error('titolo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Descrizione</label>
                <textarea name="descrizione" class="form-control form-control-sm" rows="3">{{ old('descrizione', $progetto->descrizione) }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Importo proposta (€)</label>
                    <input type="number" name="importo_proposta" step="0.01" min="0"
                           class="form-control form-control-sm @error('importo_proposta') is-invalid @enderror"
                           value="{{ old('importo_proposta', $progetto->importo_proposta) }}"
                           placeholder="Es. 11.000">
                    @error('importo_proposta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Importo accettato (€)</label>
                    <input type="number" name="valore_totale" step="0.01" min="0"
                           class="form-control form-control-sm @error('valore_totale') is-invalid @enderror"
                           value="{{ old('valore_totale', $progetto->valore_totale) }}"
                           placeholder="Es. 10.000">
                    @error('valore_totale')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Stato <span class="text-danger">*</span></label>
                    <select name="stato" class="form-select form-select-sm" required>
                        @foreach(['bozza'=>'Bozza','offerta_inviata'=>'Offerta inviata','accettato'=>'Accettato','in_corso'=>'In corso','completato'=>'Completato','annullato'=>'Annullato'] as $val=>$lab)
                            <option value="{{ $val }}" {{ old('stato', $progetto->stato) == $val ? 'selected' : '' }}>{{ $lab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Data offerta</label>
                    <input type="date" name="data_offerta" class="form-control form-control-sm"
                           value="{{ old('data_offerta', $progetto->data_offerta?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Data accettazione</label>
                    <input type="date" name="data_accettazione" class="form-control form-control-sm"
                           value="{{ old('data_accettazione', $progetto->data_accettazione?->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold">Note interne</label>
                <textarea name="note" class="form-control form-control-sm" rows="2">{{ old('note', $progetto->note) }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check-lg me-1"></i>Salva modifiche
                </button>
                <a href="{{ route('progetti.show', $progetto) }}" class="btn btn-outline-secondary btn-sm">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection
