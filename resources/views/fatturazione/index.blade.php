@extends('layouts.app')
@section('title', 'Fatturazione')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="mb-0 fw-semibold">Fatturazione — {{ $mesi[$mese] }} {{ $anno }}</h5>
    <span class="fs-5 fw-bold text-success">Totale: € {{ number_format($totale, 2, ',', '.') }}</span>
</div>

{{-- Selettore mese/anno --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label small mb-1">Anno</label>
                <select name="anno" class="form-select form-select-sm">
                    @foreach($anni as $a)
                        <option value="{{ $a }}" {{ $a == $anno ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label small mb-1">Mese</label>
                <select name="mese" class="form-select form-select-sm">
                    @foreach($mesi as $n => $nome)
                        <option value="{{ $n }}" {{ $n == $mese ? 'selected' : '' }}>{{ $nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary">Visualizza</button>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('export.fatturazione', ['anno'=>$anno,'mese'=>$mese]) }}" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-download me-1"></i>CSV
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabella voci --}}
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
                        <th class="text-end">Prezzo €</th>
                        <th>Scadenza</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($voci as $v)
                    @php
                        $periodoColor = match($v['periodicita']) {
                            'mensile'     => 'primary',
                            'trimestrale' => 'info',
                            'semestrale'  => 'purple',
                            'annuale'     => 'success',
                            'biennale'    => 'dark',
                            'progetto'    => 'warning',
                            default       => 'secondary',
                        };
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $v['cliente'] }}</td>
                        <td class="text-muted">{{ $v['descrizione'] }}</td>
                        <td>{{ $v['tipologia'] }}</td>
                        <td>
                            <span class="badge bg-{{ $periodoColor }}">{{ $v['periodicita'] }}</span>
                        </td>
                        <td class="text-end fw-semibold">
                            @if($v['prezzo'] > 0)
                                {{ number_format($v['prezzo'], 2, ',', '.') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $v['scadenza'] ?? '<span class="badge bg-primary">mensile</span>' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Nessuna voce da fatturare per {{ $mesi[$mese] }} {{ $anno }}.
                        </td>
                    </tr>
                @endforelse
                </tbody>
                @if($voci->count() > 0)
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="4" class="text-end">Totale</td>
                        <td class="text-end text-success">{{ number_format($totale, 2, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection
