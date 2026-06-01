@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
.stat-card { border-left: 4px solid; }
.stat-card.scadute    { border-color: #dc3545; }
.stat-card.urgenti    { border-color: #fd7e14; }
.stat-card.mese       { border-color: #0d6efd; }
.stat-card.clienti    { border-color: #198754; }
</style>
@endpush

@section('content')
{{-- KPI Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card clienti h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-people text-success fs-4"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $clientiAttivi }}</div>
                    <div class="text-muted small">Clienti attivi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card mese h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-calendar3 text-primary fs-4"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $scadenzeDelMese }}</div>
                    <div class="text-muted small">Scadenze questo mese</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card urgenti h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $scadenzeEntro30 }}</div>
                    <div class="text-muted small">In scadenza (30gg)</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card scadute h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-x-circle text-danger fs-4"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $scadute }}</div>
                    <div class="text-muted small">Scadute</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Scadenze urgenti --}}
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-2">
                <span class="fw-semibold"><i class="bi bi-alarm me-1 text-warning"></i>Prossime scadenze (30 giorni)</span>
                <a href="{{ route('scadenze.index', ['periodo' => '30gg']) }}" class="btn btn-sm btn-outline-secondary">Vedi tutte</a>
            </div>
            <div class="card-body p-0">
                @if($prossimeScadenze->isEmpty())
                    <p class="text-muted text-center py-4 mb-0"><i class="bi bi-check2-circle fs-3 d-block mb-1 text-success"></i>Nessuna scadenza imminente</p>
                @else
                <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Cliente</th>
                            <th>Servizio</th>
                            <th>Tipologia</th>
                            <th>Scadenza</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($prossimeScadenze as $s)
                        @php
                            $giorni = (int) now()->diffInDays($s->data_scadenza, false);
                            $badge = $giorni < 0 ? 'danger' : ($giorni <= 30 ? 'warning' : 'success');
                            $label = $giorni < 0 ? 'Scaduta' : ($giorni == 0 ? 'Oggi' : 'tra '.$giorni.'gg');
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('clienti.show', $s->articolo->cliente) }}" class="text-decoration-none fw-semibold">
                                    {{ $s->articolo->cliente->ragione_sociale }}
                                </a>
                            </td>
                            <td class="text-muted small">{{ $s->articolo->descrizione }}</td>
                            <td>
                                @if($s->articolo->tipologia)
                                    <span class="badge" style="background:{{ $s->articolo->tipologia->colore ?? '#6c757d' }}">
                                        {{ $s->articolo->tipologia->nome }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                                <span class="text-muted small ms-1">{{ $s->data_scadenza->format('d/m/Y') }}</span>
                            </td>
                            <td class="text-nowrap">
                                <form method="POST" action="{{ route('scadenze.rinnova', $s) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-xs btn-outline-success" title="Rinnova">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                                <a href="{{ route('scadenze.edit', $s) }}" class="btn btn-xs btn-outline-secondary ms-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Forecast mini --}}
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header bg-white py-2">
                <span class="fw-semibold"><i class="bi bi-graph-up-arrow me-1 text-primary"></i>Forecast prossimi 6 mesi</span>
            </div>
            <div class="card-body">
                <canvas id="forecastChart" height="220"></canvas>
                @if(collect($forecastMesi)->sum('importo') == 0)
                    <p class="text-muted text-center small mt-2">Nessun progetto con rate pianificate</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('forecastChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json(collect($forecastMesi)->pluck('label')),
        datasets: [{
            label: 'Fatturato previsto (€)',
            data: @json(collect($forecastMesi)->pluck('importo')),
            backgroundColor: 'rgba(13,110,253,.7)',
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => '€'+v.toLocaleString('it') } }
        }
    }
});
</script>
@endpush
