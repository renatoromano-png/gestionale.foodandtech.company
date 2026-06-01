@extends('layouts.app')
@section('title', 'Progetti')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div></div>
    <a href="{{ route('progetti.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nuovo progetto
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cerca per titolo…" value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <select name="cliente_id" class="form-select form-select-sm">
                    <option value="">Tutti i clienti</option>
                    @foreach($clienti as $c)
                        <option value="{{ $c->id }}" {{ request('cliente_id') == $c->id ? 'selected' : '' }}>{{ $c->ragione_sociale }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="stato" class="form-select form-select-sm">
                    <option value="">Tutti gli stati</option>
                    <option value="bozza"           {{ request('stato')=='bozza'           ? 'selected':'' }}>Bozza</option>
                    <option value="offerta_inviata"  {{ request('stato')=='offerta_inviata' ? 'selected':'' }}>Offerta inviata</option>
                    <option value="accettato"        {{ request('stato')=='accettato'       ? 'selected':'' }}>Accettato</option>
                    <option value="in_corso"         {{ request('stato')=='in_corso'        ? 'selected':'' }}>In corso</option>
                    <option value="completato"       {{ request('stato')=='completato'      ? 'selected':'' }}>Completato</option>
                    <option value="annullato"        {{ request('stato')=='annullato'       ? 'selected':'' }}>Annullato</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-secondary">Filtra</button>
                <a href="{{ route('progetti.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Titolo</th>
                        <th>Cliente</th>
                        <th>Stato</th>
                        <th class="text-end">Valore</th>
                        <th class="text-center">Rate</th>
                        <th class="text-center">Step</th>
                        <th>Data offerta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($progetti as $p)
                    <tr>
                        <td>
                            <a href="{{ route('progetti.show', $p) }}" class="fw-semibold text-decoration-none text-dark">
                                {{ $p->titolo }}
                            </a>
                        </td>
                        <td class="text-muted small">{{ $p->cliente->ragione_sociale }}</td>
                        <td>
                            @php
                                $badge = match($p->stato) {
                                    'bozza'          => 'bg-secondary-subtle text-secondary',
                                    'offerta_inviata'=> 'bg-info-subtle text-info',
                                    'accettato'      => 'bg-primary-subtle text-primary',
                                    'in_corso'       => 'bg-warning-subtle text-warning',
                                    'completato'     => 'bg-success-subtle text-success',
                                    'annullato'      => 'bg-danger-subtle text-danger',
                                    default          => 'bg-secondary-subtle text-secondary',
                                };
                                $label = match($p->stato) {
                                    'bozza'          => 'Bozza',
                                    'offerta_inviata'=> 'Offerta inviata',
                                    'accettato'      => 'Accettato',
                                    'in_corso'       => 'In corso',
                                    'completato'     => 'Completato',
                                    'annullato'      => 'Annullato',
                                    default          => $p->stato,
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ $label }}</span>
                        </td>
                        <td class="text-end fw-semibold">
                            {{ $p->valore_totale ? '€ '.number_format($p->valore_totale, 2, ',', '.') : '—' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark">{{ $p->rate->count() }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark">{{ $p->step->count() }}</span>
                        </td>
                        <td class="text-muted small">
                            {{ $p->data_offerta ? $p->data_offerta->format('d/m/Y') : '—' }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('progetti.show', $p) }}" class="btn btn-xs btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('progetti.edit', $p) }}" class="btn btn-xs btn-outline-secondary ms-1"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('progetti.destroy', $p) }}" class="d-inline"
                                  onsubmit="return confirm('Eliminare il progetto «{{ $p->titolo }}»?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Nessun progetto trovato.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($progetti->hasPages())
        <div class="card-footer bg-white py-2">{{ $progetti->links() }}</div>
    @endif
</div>
@endsection
