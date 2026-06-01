@extends('layouts.app')
@section('title', 'Account / Credenziali')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('credenziali.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Nuova credenziale</a>
</div>
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4"><input type="text" name="q" class="form-control form-control-sm" placeholder="URL, username, note…" value="{{ request('q') }}"></div>
            <div class="col-md-4">
                <select name="cliente_id" class="form-select form-select-sm">
                    <option value="">Tutti i clienti</option>
                    @foreach($clienti as $c)
                        <option value="{{ $c->id }}" {{ request('cliente_id')==$c->id ? 'selected':'' }}>{{ $c->ragione_sociale }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-secondary">Filtra</button>
                <a href="{{ route('credenziali.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-hover mb-0 small align-middle">
            <thead class="table-light">
                <tr><th>Cliente</th><th>Tipo</th><th>URL / Dominio</th><th>Username</th><th>Password</th><th>Note</th><th></th></tr>
            </thead>
            <tbody>
            @forelse($credenziali as $cr)
                <tr x-data="{ pwd: '••••••••', shown: false }">
                    <td><a href="{{ route('clienti.show', $cr->cliente) }}" class="text-decoration-none fw-semibold">{{ $cr->cliente->ragione_sociale }}</a></td>
                    <td><span class="badge bg-secondary">{{ $cr->tipo }}</span></td>
                    <td>@if($cr->url)<a href="{{ $cr->url }}" target="_blank" class="text-muted">{{ Str::limit($cr->url, 35) }}</a>@elseif($cr->note)<span class="text-muted">{{ Str::limit($cr->note, 35) }}</span>@else—@endif</td>
                    <td><code>{{ $cr->username }}</code></td>
                    <td>
                        <code x-text="pwd"></code>
                        <button class="btn btn-xs btn-outline-secondary ms-1" @click="
                            if (!shown) {
                                fetch('{{ route('credenziali.password', $cr) }}', {headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}})
                                    .then(r=>r.json()).then(d=>{ pwd=d.password; shown=true; });
                            } else { pwd='••••••••'; shown=false; }
                        "><i class="bi" :class="shown?'bi-eye-slash':'bi-eye'"></i></button>
                    </td>
                    <td class="text-muted">{{ Str::limit($cr->note ?? '', 30) ?: '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('credenziali.edit', $cr) }}" class="btn btn-xs btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('credenziali.destroy', $cr) }}" class="d-inline" onsubmit="return confirm('Eliminare?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nessuna credenziale trovata.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @if($credenziali->hasPages())
    <div class="card-footer bg-white py-2">{{ $credenziali->links() }}</div>
    @endif
</div>
@endsection
