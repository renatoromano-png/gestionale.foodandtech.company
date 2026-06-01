@extends('layouts.app')
@section('title', 'Domini')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('domini.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Nuovo dominio</a>
</div>
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4"><input type="text" name="q" class="form-control form-control-sm" placeholder="Cerca dominio…" value="{{ request('q') }}"></div>
            <div class="col-md-4">
                <select name="cliente_id" class="form-select form-select-sm">
                    <option value="">Tutti i clienti</option>
                    @foreach($clienti as $c)
                        <option value="{{ $c->id }}" {{ request('cliente_id')==$c->id ? 'selected':'' }}>{{ $c->ragione_sociale }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="solo_dns" class="form-select form-select-sm">
                    <option value="">Tutti</option>
                    <option value="1" {{ request('solo_dns')=='1'?'selected':'' }}>Solo DNS</option>
                    <option value="0" {{ request('solo_dns')=='0'?'selected':'' }}>Hosting</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-secondary">Filtra</button>
                <a href="{{ route('domini.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-hover mb-0 small align-middle">
            <thead class="table-light">
                <tr><th>Dominio</th><th>Cliente</th><th>Tipo</th><th>Scadenza</th><th>Prezzo €</th><th>Registrar</th><th></th></tr>
            </thead>
            <tbody>
            @forelse($domini as $d)
                <tr>
                    <td><a href="https://{{ $d->dominio }}" target="_blank" class="fw-semibold text-decoration-none">{{ $d->dominio }}</a></td>
                    <td><a href="{{ route('clienti.show', $d->cliente) }}" class="text-decoration-none text-muted">{{ $d->cliente->ragione_sociale }}</a></td>
                    <td>@if($d->solo_dns)<span class="badge bg-info text-dark">Solo DNS</span>@else<span class="badge bg-light text-muted">Hosting</span>@endif</td>
                    <td>
                        @if($d->data_scadenza)
                            @php $gg = now()->diffInDays($d->data_scadenza, false); @endphp
                            <span class="badge bg-{{ $gg < 0 ? 'danger' : ($gg <= 30 ? 'warning text-dark' : 'light text-dark border') }}">
                                {{ $d->data_scadenza->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-end">{{ $d->prezzo ? number_format($d->prezzo, 2, ',', '.') : '—' }}</td>
                    <td class="text-muted">{{ $d->registrar ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('domini.edit', $d) }}" class="btn btn-xs btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('domini.destroy', $d) }}" class="d-inline" onsubmit="return confirm('Eliminare?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nessun dominio trovato.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @if($domini->hasPages())
    <div class="card-footer bg-white py-2">{{ $domini->links() }}</div>
    @endif
</div>
@endsection
