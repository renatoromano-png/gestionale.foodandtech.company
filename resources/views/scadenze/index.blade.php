@extends('layouts.app')
@section('title', 'Scadenze')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div class="d-flex gap-2">
        <a href="{{ route('scadenze.index', ['periodo'=>'scadute']) }}" class="btn btn-sm {{ request('periodo')=='scadute' ? 'btn-danger' : 'btn-outline-danger' }}">Scadute</a>
        <a href="{{ route('scadenze.index', ['periodo'=>'30gg']) }}" class="btn btn-sm {{ request('periodo')=='30gg' ? 'btn-warning' : 'btn-outline-warning' }}">30gg</a>
        <a href="{{ route('scadenze.index', ['periodo'=>'60gg']) }}" class="btn btn-sm {{ request('periodo')=='60gg' ? 'btn-secondary' : 'btn-outline-secondary' }}">60gg</a>
        <a href="{{ route('scadenze.index') }}" class="btn btn-sm btn-outline-secondary">Tutte</a>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('export.scadenze') }}" class="btn btn-sm btn-outline-success"><i class="bi bi-download me-1"></i>CSV</a>
        <a href="{{ route('scadenze.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Nuova scadenza</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            @if(request('periodo'))<input type="hidden" name="periodo" value="{{ request('periodo') }}">@endif
            <div class="col-md-4">
                <select name="cliente_id" class="form-select form-select-sm">
                    <option value="">Tutti i clienti</option>
                    @foreach($clienti as $c)
                        <option value="{{ $c->id }}" {{ request('cliente_id') == $c->id ? 'selected' : '' }}>{{ $c->ragione_sociale }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="tipologia_id" class="form-select form-select-sm">
                    <option value="">Tutte le tipologie</option>
                    @foreach($tipologie as $t)
                        <option value="{{ $t->id }}" {{ request('tipologia_id') == $t->id ? 'selected' : '' }}>{{ $t->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-secondary">Filtra</button>
                <a href="{{ route('scadenze.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle small">
            <thead class="table-light">
                <tr>
                    <th>Cliente</th>
                    <th>Servizio / Descrizione</th>
                    <th>Tipologia</th>
                    <th>Periodo</th>
                    <th>Scadenza</th>
                    <th>Stato</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($scadenze as $s)
                @continue(! $s->articolo || ! $s->articolo->cliente)
                @php
                    $giorni = now()->diffInDays($s->data_scadenza, false);
                    if ($giorni < 0)      { $bg = 'danger';  $label = 'Scaduta da '.abs($giorni).'gg'; }
                    elseif ($giorni == 0) { $bg = 'danger';  $label = 'Scade oggi'; }
                    elseif ($giorni <= 30){ $bg = 'warning'; $label = 'tra '.$giorni.'gg'; }
                    elseif ($giorni <= 60){ $bg = 'secondary'; $label = 'tra '.$giorni.'gg'; }
                    else                 { $bg = 'success'; $label = 'tra '.$giorni.'gg'; }
                    $periodMap = ['mensile'=>'mensile','trimestrale'=>'trim.','semestrale'=>'sem.','annuale'=>'ann.','biennale'=>'biennale','una_tantum'=>'una tantum'];
                    $period = $s->articolo->tipologia->periodicita ?? null;
                    $periodLabel = $period ? ($periodMap[$period] ?? $period) : null;
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('clienti.show', $s->articolo->cliente) }}" class="text-decoration-none fw-semibold">
                            {{ $s->articolo->cliente->ragione_sociale }}
                        </a>
                    </td>
                    <td class="text-muted">{{ $s->articolo->descrizione }}</td>
                    <td>
                        @if($s->articolo->tipologia)
                            <span class="badge" style="background:{{ $s->articolo->tipologia->colore ?? '#aaa' }}">
                                {{ $s->articolo->tipologia->nome }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($periodLabel)
                            <span class="badge bg-light text-dark border">{{ $periodLabel }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $s->data_scadenza->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $bg }} {{ $bg=='warning' ? 'text-dark' : '' }}">{{ $label }}</span>
                    </td>
                    <td class="text-end">
                        <form method="POST" action="{{ route('scadenze.rinnova', $s) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-xs btn-outline-success" title="Rinnova"><i class="bi bi-arrow-clockwise"></i></button>
                        </form>
                        <a href="{{ route('scadenze.edit', $s) }}" class="btn btn-xs btn-outline-secondary ms-1"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('scadenze.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Eliminare?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Nessuna scadenza trovata.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @if($scadenze->hasPages())
    <div class="card-footer bg-white py-2">{{ $scadenze->links() }}</div>
    @endif
</div>
@endsection
