<div class="mb-3">
    <label class="form-label small fw-semibold">Cliente *</label>
    @if(isset($scadenza))
        <input type="text" class="form-control" disabled value="{{ $scadenza->articolo->cliente->ragione_sociale }}">
    @else
        <select name="cliente_id" class="form-select" required>
            <option value="">Seleziona cliente…</option>
            @foreach($clienti as $c)
                <option value="{{ $c->id }}" {{ old('cliente_id', request('cliente_id')) == $c->id ? 'selected' : '' }}>{{ $c->ragione_sociale }}</option>
            @endforeach
        </select>
    @endif
</div>
<div class="mb-3">
    <label class="form-label small fw-semibold">Tipologia</label>
    <select name="tipologia_id" class="form-select">
        <option value="">— nessuna —</option>
        @foreach($tipologie as $t)
            <option value="{{ $t->id }}"
                {{ old('tipologia_id', $scadenza->articolo->tipologia_id ?? '') == $t->id ? 'selected' : '' }}
                data-color="{{ $t->colore }}">
                {{ $t->nome }} ({{ $t->periodicita }})
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label small fw-semibold">Descrizione *</label>
    <input type="text" name="descrizione" class="form-control" required
        value="{{ old('descrizione', $scadenza->articolo->descrizione ?? '') }}" placeholder="es. info@cert.cliente.it">
</div>
<div class="row g-2">
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-semibold">Prezzo (€)</label>
        <input type="number" name="prezzo" class="form-control" step="0.01" min="0"
            value="{{ old('prezzo', $scadenza->articolo->prezzo ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label small fw-semibold">Data Scadenza *</label>
        <input type="date" name="data_scadenza" class="form-control" required
            value="{{ old('data_scadenza', isset($scadenza) ? $scadenza->data_scadenza->format('Y-m-d') : '') }}">
    </div>
</div>
<div class="mb-3">
    <label class="form-label small fw-semibold">Note</label>
    <textarea name="note" class="form-control" rows="2">{{ old('note', $scadenza->note ?? '') }}</textarea>
</div>
