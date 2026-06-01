<div class="mb-3">
    <label class="form-label small fw-semibold">Cliente *</label>
    <select name="cliente_id" class="form-select" required>
        <option value="">Seleziona…</option>
        @foreach($clienti as $c)
            <option value="{{ $c->id }}" {{ old('cliente_id', $credenziale->cliente_id ?? request('cliente_id')) == $c->id ? 'selected' : '' }}>{{ $c->ragione_sociale }}</option>
        @endforeach
    </select>
</div>
<div class="row g-2 mb-3">
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Tipo *</label>
        <input type="text" name="tipo" class="form-control" required value="{{ old('tipo', $credenziale->tipo ?? 'cPanel') }}" placeholder="cPanel, FTP, SSH…">
    </div>
    <div class="col-md-8">
        <label class="form-label small fw-semibold">URL / Pannello</label>
        <input type="text" name="url" class="form-control" value="{{ old('url', $credenziale->url ?? '') }}" placeholder="https://...">
    </div>
</div>
<div class="row g-2 mb-3">
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Username *</label>
        <input type="text" name="username" class="form-control" required value="{{ old('username', $credenziale->username ?? '') }}">
    </div>
    <div class="col-md-6" x-data="{ show: false }">
        <label class="form-label small fw-semibold">Password {{ isset($credenziale) ? '(lascia vuoto per non cambiare)' : '*' }}</label>
        <div class="input-group">
            <input :type="show ? 'text' : 'password'" name="password_enc" class="form-control"
                {{ !isset($credenziale) ? 'required' : '' }}
                value="{{ old('password_enc', $passwordChiara ?? '') }}">
            <button type="button" class="btn btn-outline-secondary" @click="show=!show">
                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
            </button>
        </div>
    </div>
</div>
<div class="mb-3">
    <label class="form-label small fw-semibold">Note</label>
    <textarea name="note" class="form-control" rows="2" placeholder="es. nome dominio associato">{{ old('note', $credenziale->note ?? '') }}</textarea>
</div>
