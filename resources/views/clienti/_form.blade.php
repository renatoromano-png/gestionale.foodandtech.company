<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label small fw-semibold">Ragione Sociale *</label>
        <input type="text" name="ragione_sociale" class="form-control" required value="{{ old('ragione_sociale', $cliente->ragione_sociale ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Codice</label>
        <input type="text" name="codice" class="form-control" value="{{ old('codice', $cliente->codice ?? '') }}" maxlength="20">
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Indirizzo</label>
        <input type="text" name="indirizzo" class="form-control" value="{{ old('indirizzo', $cliente->indirizzo ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">CAP</label>
        <input type="text" name="cap" class="form-control" value="{{ old('cap', $cliente->cap ?? '') }}" maxlength="10">
    </div>
    <div class="col-md-5">
        <label class="form-label small fw-semibold">Città</label>
        <input type="text" name="citta" class="form-control" value="{{ old('citta', $cliente->citta ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Provincia</label>
        <input type="text" name="provincia" class="form-control" value="{{ old('provincia', $cliente->provincia ?? '') }}" maxlength="5">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Telefono</label>
        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">PEC <span class="text-muted fw-normal">(opzionale)</span></label>
        <input type="email" name="pec" class="form-control" value="{{ old('pec', $cliente->pec ?? '') }}" placeholder="es. azienda@pec.it">
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Codice SDI <span class="text-muted fw-normal">(opzionale)</span></label>
        <input type="text" name="codice_sdi" class="form-control" value="{{ old('codice_sdi', $cliente->codice_sdi ?? '') }}" maxlength="7" placeholder="es. 0000000">
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Note</label>
        <textarea name="note" class="form-control" rows="2">{{ old('note', $cliente->note ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="attivo" id="attivo" value="1"
                {{ old('attivo', ($cliente->attivo ?? true) ? '1' : '') == '1' ? 'checked' : '' }}>
            <label class="form-check-label small" for="attivo">Cliente attivo</label>
        </div>
    </div>
</div>
