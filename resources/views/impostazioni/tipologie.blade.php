@extends('layouts.app')
@section('title', 'Tipologie Servizio')
@section('content')

<div class="row g-3">
    {{-- Lista --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-2 fw-semibold">
                <i class="bi bi-tags me-1"></i>Tipologie configurate ({{ $tipologie->count() }})
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 small align-middle">
                    <thead class="table-light">
                        <tr><th>Nome</th><th>Periodicità</th><th>Prezzo default</th><th>Colore</th><th>Stato</th><th></th></tr>
                    </thead>
                    <tbody>
                    @forelse($tipologie as $t)
                        <tr>
                            <td class="fw-semibold">
                                <span class="badge me-1" style="background:{{ $t->colore ?? '#aaa' }}">&nbsp;</span>
                                {{ $t->nome }}
                            </td>
                            <td class="text-muted">{{ ucfirst($t->periodicita) }}</td>
                            <td>{{ $t->prezzo_default ? '€'.number_format($t->prezzo_default,2,',','.') : '—' }}</td>
                            <td><code style="font-size:.75rem">{{ $t->colore }}</code></td>
                            <td>@if($t->attivo)<span class="badge bg-success-subtle text-success">Attiva</span>@else<span class="badge bg-secondary-subtle text-secondary">Disattiva</span>@endif</td>
                            <td class="text-end">
                                <button class="btn btn-xs btn-outline-secondary"
                                    onclick="editTipologia({{ $t->toJson() }})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form method="POST" action="{{ route('tipologie.destroy', $t) }}" class="d-inline"
                                    onsubmit="return confirm('Eliminare \'{{ $t->nome }}\'?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-xs btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nessuna tipologia.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Form aggiungi/modifica --}}
    <div class="col-lg-4">
        <div class="card" id="tipologiaFormCard">
            <div class="card-header bg-white py-2 fw-semibold">
                <i class="bi bi-plus-circle me-1"></i><span id="formTitle">Nuova Tipologia</span>
            </div>
            <div class="card-body">
                <form method="POST" id="tipologiaForm" action="{{ route('tipologie.store') }}">
                    @csrf
                    <span id="methodSpan"></span>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Nome *</label>
                        <input type="text" name="nome" id="f_nome" class="form-control form-control-sm" required>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-7">
                            <label class="form-label small fw-semibold">Periodicità *</label>
                            <select name="periodicita" id="f_periodicita" class="form-select form-select-sm" required>
                                <option value="mensile">Mensile</option>
                                <option value="trimestrale">Trimestrale</option>
                                <option value="semestrale">Semestrale</option>
                                <option value="annuale" selected>Annuale</option>
                                <option value="biennale">Biennale</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <label class="form-label small fw-semibold">Colore</label>
                            <input type="color" name="colore" id="f_colore" class="form-control form-control-sm form-control-color w-100" value="#0d6efd">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Prezzo default (€)</label>
                        <input type="number" name="prezzo_default" id="f_prezzo" class="form-control form-control-sm" step="0.01" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Descrizione</label>
                        <textarea name="descrizione" id="f_desc" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="attivo" id="f_attivo" class="form-check-input" value="1" checked>
                        <label class="form-check-label small" for="f_attivo">Attiva</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary">Salva</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editTipologia(t) {
    document.getElementById('formTitle').textContent = 'Modifica: ' + t.nome;
    document.getElementById('tipologiaForm').action = '/tipologie/' + t.id;
    document.getElementById('methodSpan').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('f_nome').value        = t.nome;
    document.getElementById('f_periodicita').value = t.periodicita;
    document.getElementById('f_colore').value      = t.colore || '#0d6efd';
    document.getElementById('f_prezzo').value      = t.prezzo_default || '';
    document.getElementById('f_desc').value        = t.descrizione || '';
    document.getElementById('f_attivo').checked    = !!t.attivo;
    document.getElementById('tipologiaFormCard').scrollIntoView({behavior:'smooth'});
}
function resetForm() {
    document.getElementById('formTitle').textContent = 'Nuova Tipologia';
    document.getElementById('tipologiaForm').action  = '{{ route('tipologie.store') }}';
    document.getElementById('methodSpan').innerHTML  = '';
    document.getElementById('tipologiaForm').reset();
    document.getElementById('f_colore').value = '#0d6efd';
    document.getElementById('f_attivo').checked = true;
}
</script>
@endpush
