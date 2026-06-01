@extends('layouts.app')
@section('title', 'Nuovo Progetto')
@section('content')

<div class="mb-3">
    <a href="{{ route('progetti.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Torna ai progetti
    </a>
</div>

<div class="card" style="max-width:720px">
    <div class="card-header bg-white fw-semibold">Nuovo Progetto</div>
    <div class="card-body">
        <form method="POST" action="{{ route('progetti.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label small fw-semibold">Cliente <span class="text-danger">*</span></label>
                <select name="cliente_id" class="form-select form-select-sm @error('cliente_id') is-invalid @enderror" required>
                    <option value="">— Seleziona cliente —</option>
                    @foreach($clienti as $c)
                        <option value="{{ $c->id }}" {{ (old('cliente_id', request('cliente_id'))) == $c->id ? 'selected' : '' }}>{{ $c->ragione_sociale }}</option>
                    @endforeach
                </select>
                @error('cliente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Titolo progetto <span class="text-danger">*</span></label>
                <input type="text" name="titolo" class="form-control form-control-sm @error('titolo') is-invalid @enderror"
                       value="{{ old('titolo') }}" required>
                @error('titolo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Descrizione</label>
                <textarea name="descrizione" class="form-control form-control-sm" rows="3">{{ old('descrizione') }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Importo proposta (€)</label>
                    <input type="number" name="importo_proposta" step="0.01" min="0"
                           class="form-control form-control-sm @error('importo_proposta') is-invalid @enderror"
                           value="{{ old('importo_proposta') }}"
                           placeholder="Es. 11.000">
                    @error('importo_proposta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Importo accettato (€)</label>
                    <input type="number" name="valore_totale" step="0.01" min="0"
                           class="form-control form-control-sm @error('valore_totale') is-invalid @enderror"
                           value="{{ old('valore_totale') }}"
                           placeholder="Es. 10.000">
                    @error('valore_totale')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Stato <span class="text-danger">*</span></label>
                    <select name="stato" class="form-select form-select-sm" required>
                        @foreach(['bozza'=>'Bozza','offerta_inviata'=>'Offerta inviata','accettato'=>'Accettato','in_corso'=>'In corso','completato'=>'Completato','annullato'=>'Annullato'] as $val=>$lab)
                            <option value="{{ $val }}" {{ old('stato', 'bozza') == $val ? 'selected' : '' }}>{{ $lab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Data offerta</label>
                    <input type="date" name="data_offerta" class="form-control form-control-sm" value="{{ old('data_offerta') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Data accettazione</label>
                    <input type="date" name="data_accettazione" class="form-control form-control-sm" value="{{ old('data_accettazione') }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold">Note interne</label>
                <textarea name="note" class="form-control form-control-sm" rows="2">{{ old('note') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check-lg me-1"></i>Crea progetto
                </button>
                <a href="{{ route('progetti.index') }}" class="btn btn-outline-secondary btn-sm">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection
