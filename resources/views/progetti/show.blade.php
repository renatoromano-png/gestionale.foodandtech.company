@extends('layouts.app')
@section('title', $progetto->titolo)

@push('styles')
<style>
    .step-row { transition: background .15s; }
    .step-row:hover { background: #f8f9fa; }
    .rata-row { transition: background .15s; }
    .rata-row:hover { background: #f8f9fa; }
    .badge-stato-da_fare    { background: #e9ecef; color: #495057; }
    .badge-stato-in_corso   { background: #fff3cd; color: #856404; }
    .badge-stato-completato { background: #d1e7dd; color: #0f5132; }
    .collapse-form { background: #f8f9fa; border-top: 1px solid #dee2e6; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-3">
    <a href="{{ route('progetti.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Progetti
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('progetti.edit', $progetto) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i>Modifica
        </a>
        <form method="POST" action="{{ route('progetti.destroy', $progetto) }}"
              onsubmit="return confirm('Eliminare il progetto?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>

{{-- Info progetto --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="text-muted small mb-1">Cliente</div>
                <div class="fw-semibold">{{ $progetto->cliente->ragione_sociale }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small mb-1">Stato</div>
                @php
                    $badge = match($progetto->stato) {
                        'bozza'          => 'bg-secondary-subtle text-secondary',
                        'offerta_inviata'=> 'bg-info-subtle text-info',
                        'accettato'      => 'bg-primary-subtle text-primary',
                        'in_corso'       => 'bg-warning-subtle text-warning',
                        'completato'     => 'bg-success-subtle text-success',
                        'annullato'      => 'bg-danger-subtle text-danger',
                        default          => 'bg-secondary-subtle text-secondary',
                    };
                    $label = match($progetto->stato) {
                        'bozza'          => 'Bozza',
                        'offerta_inviata'=> 'Offerta inviata',
                        'accettato'      => 'Accettato',
                        'in_corso'       => 'In corso',
                        'completato'     => 'Completato',
                        'annullato'      => 'Annullato',
                        default          => $progetto->stato,
                    };
                @endphp
                <span class="badge {{ $badge }} fs-6">{{ $label }}</span>
            </div>
            @if($progetto->importo_proposta)
            <div class="col-md-3">
                <div class="text-muted small mb-1">Importo proposta</div>
                <div class="fw-semibold text-muted">€ {{ number_format($progetto->importo_proposta, 2, ',', '.') }}</div>
            </div>
            @endif
            <div class="col-md-3">
                <div class="text-muted small mb-1">Importo accettato</div>
                <div class="fw-bold fs-5">
                    {{ $progetto->valore_totale ? '€ '.number_format($progetto->valore_totale, 2, ',', '.') : '—' }}
                </div>
            </div>
            @if($progetto->data_offerta)
            <div class="col-md-3">
                <div class="text-muted small mb-1">Data offerta</div>
                <div>{{ $progetto->data_offerta->format('d/m/Y') }}</div>
            </div>
            @endif
            @if($progetto->data_accettazione)
            <div class="col-md-3">
                <div class="text-muted small mb-1">Data accettazione</div>
                <div>{{ $progetto->data_accettazione->format('d/m/Y') }}</div>
            </div>
            @endif
            @if($progetto->descrizione)
            <div class="col-12">
                <div class="text-muted small mb-1">Descrizione</div>
                <div>{{ $progetto->descrizione }}</div>
            </div>
            @endif
            @if($progetto->note)
            <div class="col-12">
                <div class="text-muted small mb-1">Note interne</div>
                <div class="text-muted fst-italic small">{{ $progetto->note }}</div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row g-4">

{{-- ═══════════════ RATE ═══════════════ --}}
<div class="col-lg-5">
    <div class="card h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="bi bi-cash-coin me-1"></i>Rate di pagamento</span>
            <button class="btn btn-xs btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#formNuovaRata">
                <i class="bi bi-plus-lg"></i> Aggiungi
            </button>
        </div>

        {{-- Form nuova rata --}}
        <div class="collapse collapse-form" id="formNuovaRata">
            <div class="p-3">
                <form method="POST" action="{{ route('progetti.rate.store', $progetto) }}">
                    @csrf
                    <div class="mb-2">
                        <input type="text" name="descrizione" class="form-control form-control-sm"
                               placeholder="Es. Acconto, SAL 1, Saldo…" required>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="number" name="importo" class="form-control form-control-sm"
                                   placeholder="Importo €" step="0.01" min="0" required>
                        </div>
                        <div class="col-6">
                            <input type="number" name="percentuale" class="form-control form-control-sm"
                                   placeholder="% (opz.)" step="0.01" min="0" max="100">
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="date" name="data_prevista" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <select name="stato" class="form-select form-select-sm">
                                <option value="attesa">In attesa</option>
                                <option value="incassata">Incassata</option>
                                <option value="in_ritardo">In ritardo</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-check-lg me-1"></i>Aggiungi rata
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            @forelse($progetto->rate as $rata)
            <div class="rata-row p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-semibold small">{{ $rata->descrizione }}</div>
                        <div class="fw-bold text-primary">€ {{ number_format($rata->importo, 2, ',', '.') }}</div>
                        @if($rata->percentuale)
                            <div class="text-muted" style="font-size:.75rem">{{ number_format($rata->percentuale,0) }}%</div>
                        @endif
                        @if($rata->data_prevista)
                            <div class="text-muted" style="font-size:.75rem">
                                <i class="bi bi-calendar3 me-1"></i>Prevista: {{ $rata->data_prevista->format('d/m/Y') }}
                            </div>
                        @endif
                        @if($rata->data_incasso)
                            <div class="text-success" style="font-size:.75rem">
                                <i class="bi bi-check-circle me-1"></i>Incassata: {{ $rata->data_incasso->format('d/m/Y') }}
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        @php
                            $rbadge = match($rata->stato) {
                                'incassata'  => 'bg-success-subtle text-success',
                                'in_ritardo' => 'bg-danger-subtle text-danger',
                                default      => 'bg-secondary-subtle text-secondary',
                            };
                            $rlabel = match($rata->stato) {
                                'incassata'  => 'Incassata',
                                'in_ritardo' => 'In ritardo',
                                default      => 'In attesa',
                            };
                        @endphp
                        <span class="badge {{ $rbadge }}">{{ $rlabel }}</span>
                        <div class="d-flex gap-1 mt-1">
                            <button class="btn btn-xs btn-outline-secondary"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#editRata{{ $rata->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('progetti.rate.destroy', [$progetto, $rata]) }}"
                                  onsubmit="return confirm('Eliminare questa rata?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Form modifica rata --}}
                <div class="collapse mt-2" id="editRata{{ $rata->id }}">
                    <form method="POST" action="{{ route('progetti.rate.update', [$progetto, $rata]) }}" class="bg-white rounded p-2 border">
                        @csrf @method('PATCH')
                        <div class="mb-2">
                            <input type="text" name="descrizione" class="form-control form-control-sm"
                                   value="{{ $rata->descrizione }}" required>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <input type="number" name="importo" class="form-control form-control-sm"
                                       value="{{ $rata->importo }}" step="0.01" min="0" required>
                            </div>
                            <div class="col-6">
                                <input type="number" name="percentuale" class="form-control form-control-sm"
                                       value="{{ $rata->percentuale }}" step="0.01" min="0" max="100" placeholder="% (opz.)">
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label" style="font-size:.7rem">Data prevista</label>
                                <input type="date" name="data_prevista" class="form-control form-control-sm"
                                       value="{{ $rata->data_prevista?->format('Y-m-d') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label" style="font-size:.7rem">Data incasso</label>
                                <input type="date" name="data_incasso" class="form-control form-control-sm"
                                       value="{{ $rata->data_incasso?->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="mb-2">
                            <select name="stato" class="form-select form-select-sm">
                                <option value="attesa"      {{ $rata->stato=='attesa'      ? 'selected':'' }}>In attesa</option>
                                <option value="incassata"   {{ $rata->stato=='incassata'   ? 'selected':'' }}>Incassata</option>
                                <option value="in_ritardo"  {{ $rata->stato=='in_ritardo'  ? 'selected':'' }}>In ritardo</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Salva</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4 small">Nessuna rata aggiunta.</div>
            @endforelse
        </div>

        @if($progetto->rate->count() > 0)
        <div class="card-footer bg-white py-2">
            @php
                $totRate      = $progetto->rate->sum('importo');
                $totIncassato = $progetto->rate->where('stato','incassata')->sum('importo');
                $totAttesa    = $totRate - $totIncassato;
            @endphp
            <div class="d-flex justify-content-between small">
                <span class="text-muted">Totale rate:</span>
                <span class="fw-semibold">€ {{ number_format($totRate, 2, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between small">
                <span class="text-success">Incassato:</span>
                <span class="fw-semibold text-success">€ {{ number_format($totIncassato, 2, ',', '.') }}</span>
            </div>
            @if($totAttesa > 0)
            <div class="d-flex justify-content-between small">
                <span class="text-muted">Da incassare:</span>
                <span class="fw-semibold text-warning">€ {{ number_format($totAttesa, 2, ',', '.') }}</span>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

{{-- ═══════════════ STEP ═══════════════ --}}
<div class="col-lg-7">
    <div class="card h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="bi bi-list-check me-1"></i>Step / Fasi lavoro</span>
            <button class="btn btn-xs btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#formNuovoStep">
                <i class="bi bi-plus-lg"></i> Aggiungi
            </button>
        </div>

        {{-- Form nuovo step --}}
        <div class="collapse collapse-form" id="formNuovoStep">
            <div class="p-3">
                <form method="POST" action="{{ route('progetti.step.store', $progetto) }}">
                    @csrf
                    <div class="mb-2">
                        <input type="text" name="titolo" class="form-control form-control-sm"
                               placeholder="Titolo step…" required>
                    </div>
                    <div class="mb-2">
                        <textarea name="descrizione" class="form-control form-control-sm" rows="2"
                                  placeholder="Descrizione (opzionale)"></textarea>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <select name="stato" class="form-select form-select-sm">
                                <option value="da_fare">Da fare</option>
                                <option value="in_corso">In corso</option>
                                <option value="completato">Completato</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="date" name="data_prevista" class="form-control form-control-sm">
                        </div>
                        @if($progetto->rate->count() > 0)
                        <div class="col-4">
                            <select name="rata_id" class="form-select form-select-sm">
                                <option value="">— Rata (opz.) —</option>
                                @foreach($progetto->rate as $r)
                                    <option value="{{ $r->id }}">{{ $r->descrizione }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-check-lg me-1"></i>Aggiungi step
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            @forelse($progetto->step as $step)
            <div class="step-row p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1 me-2">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge badge-stato-{{ $step->stato }}">
                                {{ match($step->stato) { 'da_fare'=>'Da fare','in_corso'=>'In corso','completato'=>'Completato', default=>$step->stato } }}
                            </span>
                            <span class="fw-semibold small {{ $step->stato=='completato' ? 'text-decoration-line-through text-muted' : '' }}">
                                {{ $step->titolo }}
                            </span>
                        </div>
                        @if($step->descrizione)
                            <div class="text-muted small">{{ $step->descrizione }}</div>
                        @endif
                        <div class="d-flex gap-3 mt-1" style="font-size:.72rem; color:#6c757d">
                            @if($step->data_prevista)
                                <span><i class="bi bi-calendar3 me-1"></i>{{ $step->data_prevista->format('d/m/Y') }}</span>
                            @endif
                            @if($step->data_completamento)
                                <span class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $step->data_completamento->format('d/m/Y') }}</span>
                            @endif
                            @if($step->rata)
                                <span><i class="bi bi-cash-coin me-1"></i>{{ $step->rata->descrizione }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        <button class="btn btn-xs btn-outline-secondary"
                                data-bs-toggle="collapse"
                                data-bs-target="#editStep{{ $step->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="POST" action="{{ route('progetti.step.destroy', [$progetto, $step]) }}"
                              onsubmit="return confirm('Eliminare questo step?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>

                {{-- Form modifica step --}}
                <div class="collapse mt-2" id="editStep{{ $step->id }}">
                    <form method="POST" action="{{ route('progetti.step.update', [$progetto, $step]) }}" class="bg-white rounded p-2 border">
                        @csrf @method('PATCH')
                        <div class="mb-2">
                            <input type="text" name="titolo" class="form-control form-control-sm"
                                   value="{{ $step->titolo }}" required>
                        </div>
                        <div class="mb-2">
                            <textarea name="descrizione" class="form-control form-control-sm" rows="2">{{ $step->descrizione }}</textarea>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-4">
                                <select name="stato" class="form-select form-select-sm">
                                    <option value="da_fare"    {{ $step->stato=='da_fare'    ? 'selected':'' }}>Da fare</option>
                                    <option value="in_corso"   {{ $step->stato=='in_corso'   ? 'selected':'' }}>In corso</option>
                                    <option value="completato" {{ $step->stato=='completato' ? 'selected':'' }}>Completato</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label style="font-size:.7rem">Data prevista</label>
                                <input type="date" name="data_prevista" class="form-control form-control-sm"
                                       value="{{ $step->data_prevista?->format('Y-m-d') }}">
                            </div>
                            <div class="col-4">
                                <label style="font-size:.7rem">Data completamento</label>
                                <input type="date" name="data_completamento" class="form-control form-control-sm"
                                       value="{{ $step->data_completamento?->format('Y-m-d') }}">
                            </div>
                        </div>
                        @if($progetto->rate->count() > 0)
                        <div class="mb-2">
                            <select name="rata_id" class="form-select form-select-sm">
                                <option value="">— Rata collegata (opz.) —</option>
                                @foreach($progetto->rate as $r)
                                    <option value="{{ $r->id }}" {{ $step->rata_id == $r->id ? 'selected':'' }}>{{ $r->descrizione }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm w-100">Salva</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4 small">Nessuno step aggiunto.</div>
            @endforelse
        </div>

        @if($progetto->step->count() > 0)
        <div class="card-footer bg-white py-2 small text-muted">
            @php
                $tot       = $progetto->step->count();
                $completati = $progetto->step->where('stato','completato')->count();
                $pct       = $tot > 0 ? round($completati / $tot * 100) : 0;
            @endphp
            <div class="d-flex justify-content-between mb-1">
                <span>Avanzamento</span>
                <span>{{ $completati }}/{{ $tot }} step ({{ $pct }}%)</span>
            </div>
            <div class="progress" style="height:6px">
                <div class="progress-bar bg-success" style="width:{{ $pct }}%"></div>
            </div>
        </div>
        @endif
    </div>
</div>

</div>{{-- /row --}}

@push('scripts')
<script>
// Base di calcolo = importo accettato del progetto
const baseImporto = {{ $progetto->valore_totale ?? 0 }};

function syncRata(form, changed) {
    if (baseImporto <= 0) return;
    const pctInput     = form.querySelector('[name="percentuale"]');
    const importoInput = form.querySelector('[name="importo"]');
    if (!pctInput || !importoInput) return;

    if (changed === 'pct') {
        const pct = parseFloat(pctInput.value);
        if (!isNaN(pct)) {
            importoInput.value = (baseImporto * pct / 100).toFixed(2);
        }
    } else {
        const imp = parseFloat(importoInput.value);
        if (!isNaN(imp)) {
            pctInput.value = (imp / baseImporto * 100).toFixed(2);
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function (form) {
        const pctInput     = form.querySelector('[name="percentuale"]');
        const importoInput = form.querySelector('[name="importo"]');
        if (!pctInput || !importoInput) return;

        pctInput.addEventListener('input', function () { syncRata(form, 'pct'); });
        importoInput.addEventListener('input', function () { syncRata(form, 'importo'); });
    });
});
</script>
@endpush
@endsection
