@extends('layouts.app')
@section('title', 'Clienti')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div></div>
    <a href="{{ route('clienti.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nuovo cliente
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cerca per nome, codice, email…" value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <select name="stato" class="form-select form-select-sm">
                    <option value="">Tutti gli stati</option>
                    <option value="attivo"   {{ request('stato')=='attivo'   ? 'selected' : '' }}>Attivi</option>
                    <option value="inattivo" {{ request('stato')=='inattivo' ? 'selected' : '' }}>Non attivi</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-secondary">Filtra</button>
                <a href="{{ route('clienti.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('export.clienti') }}" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-download me-1"></i>CSV
                </a>
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
                    <th>Ragione Sociale</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th class="text-center">Scadenze</th>
                    <th class="text-center">Domini</th>
                    <th class="text-center">Stato</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($clienti as $c)
                <tr>
                    <td>
                        <a href="{{ route('clienti.show', $c) }}" class="fw-semibold text-decoration-none text-dark">
                            {{ $c->ragione_sociale }}
                        </a>
                        @if($c->codice)
                            <span class="badge bg-light text-muted ms-1" style="font-size:.65rem">{{ $c->codice }}</span>
                        @endif
                        @if($c->ha_scadenze_scadute)
                            <span class="badge bg-danger ms-1" style="font-size:.65rem"><i class="bi bi-exclamation"></i>scaduta</span>
                        @elseif($c->ha_scadenze_urgenti)
                            <span class="badge bg-warning text-dark ms-1" style="font-size:.65rem"><i class="bi bi-clock"></i>urgente</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $c->email ?? '—' }}</td>
                    <td class="text-muted small">{{ $c->telefono ?? '—' }}</td>
                    <td class="text-center"><span class="badge bg-light text-dark">{{ $c->articoli_count }}</span></td>
                    <td class="text-center"><span class="badge bg-light text-dark">{{ $c->domini_count }}</span></td>
                    <td class="text-center">
                        @if($c->attivo)
                            <span class="badge bg-success-subtle text-success">Attivo</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Inattivo</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('clienti.show', $c) }}" class="btn btn-xs btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('clienti.edit', $c) }}" class="btn btn-xs btn-outline-secondary ms-1"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nessun cliente trovato.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @if($clienti->hasPages())
    <div class="card-footer bg-white py-2">{{ $clienti->links() }}</div>
    @endif
</div>
@endsection
