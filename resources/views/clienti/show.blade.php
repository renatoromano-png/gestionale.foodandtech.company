@extends('layouts.app')
@section('title', $cliente->ragione_sociale)
@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('clienti.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold">{{ $cliente->ragione_sociale }}</h5>
    @if($cliente->attivo)
        <span class="badge bg-success">Attivo</span>
    @else
        <span class="badge bg-secondary">Inattivo</span>
    @endif
    <div class="ms-auto">
        <a href="{{ route('clienti.edit', $cliente) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-pencil me-1"></i>Modifica
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white py-2 fw-semibold small">Dati anagrafici</div>
            <div class="card-body small">
                @if($cliente->codice)<p class="mb-1"><span class="text-muted">Codice:</span> {{ $cliente->codice }}</p>@endif
                @if($cliente->indirizzo)<p class="mb-1"><span class="text-muted">Indirizzo:</span> {{ $cliente->indirizzo }}</p>@endif
                @if($cliente->citta)<p class="mb-1"><span class="text-muted">Città:</span> {{ $cliente->citta }} {{ $cliente->cap }} {{ $cliente->provincia }}</p>@endif
                @if($cliente->email)<p class="mb-1"><span class="text-muted">Email:</span> <a href="mailto:{{ $cliente->email }}">{{ $cliente->email }}</a></p>@endif
                @if($cliente->telefono)<p class="mb-1"><span class="text-muted">Telefono:</span> {{ $cliente->telefono }}</p>@endif
                @if($cliente->pec)<p class="mb-1"><span class="text-muted">PEC:</span> <a href="mailto:{{ $cliente->pec }}">{{ $cliente->pec }}</a></p>@endif
                @if($cliente->codice_sdi)<p class="mb-1"><span class="text-muted">Codice SDI:</span> <code>{{ $cliente->codice_sdi }}</code></p>@endif
                @if($cliente->note)<p class="mb-0"><span class="text-muted">Note:</span> {{ $cliente->note }}</p>@endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row g-2">
            @php $sc = $cliente->articoli->flatMap->scadenze @endphp
            <div class="col-4">
                <div class="card text-center p-2">
                    <div class="fs-3 fw-bold text-primary">{{ $cliente->articoli->count() }}</div>
                    <div class="small text-muted">Servizi</div>
                </div>
            </div>
            <div class="col-4">
                <div class="card text-center p-2">
                    <div class="fs-3 fw-bold text-info">{{ $cliente->domini->count() }}</div>
                    <div class="small text-muted">Domini</div>
                </div>
            </div>
            <div class="col-4">
                <div class="card text-center p-2">
                    <div class="fs-3 fw-bold text-secondary">{{ $cliente->credenziali->count() }}</div>
                    <div class="small text-muted">Credenziali</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tab --}}
<div class="card">
    <div class="card-header bg-white p-0">
        <ul class="nav nav-tabs card-header-tabs px-3" id="clienteTabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-scadenze">
                <i class="bi bi-calendar-check me-1"></i>Scadenze <span class="badge bg-secondary ms-1">{{ $cliente->articoli->count() }}</span></a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-domini">
                <i class="bi bi-globe me-1"></i>Domini <span class="badge bg-secondary ms-1">{{ $cliente->domini->count() }}</span></a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-credenziali">
                <i class="bi bi-key me-1"></i>Credenziali <span class="badge bg-secondary ms-1">{{ $cliente->credenziali->count() }}</span></a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-progetti">
                <i class="bi bi-briefcase me-1"></i>Progetti <span class="badge bg-secondary ms-1">{{ $cliente->progetti->count() }}</span></a></li>
        </ul>
    </div>
    <div class="card-body p-0">
        <div class="tab-content">

            {{-- Scadenze --}}
            <div class="tab-pane fade show active" id="tab-scadenze">
                <div class="p-2 border-bottom d-flex justify-content-end">
                    <a href="{{ route('scadenze.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-xs btn-outline-primary">
                        <i class="bi bi-plus"></i> Aggiungi scadenza
                    </a>
                </div>
                <table class="table table-hover mb-0 small align-middle">
                    <thead class="table-light"><tr><th>Servizio</th><th>Tipologia</th><th>Scadenza</th><th>Stato</th><th></th></tr></thead>
                    <tbody>
                    @forelse($cliente->articoli as $art)
                        @foreach($art->scadenze as $s)
                        @php
                            $giorni = (int) now()->diffInDays($s->data_scadenza, false);
                            $badge = $giorni < 0 ? 'danger' : ($giorni <= 30 ? 'warning' : ($giorni <= 60 ? 'orange' : 'success'));
                            $label = $giorni < 0 ? 'Scaduta' : ($giorni == 0 ? 'Oggi' : 'tra '.$giorni.'gg');
                        @endphp
                        <tr>
                            <td>{{ $art->descrizione }}</td>
                            <td>@if($art->tipologia)<span class="badge" style="background:{{ $art->tipologia->colore ?? '#aaa' }}">{{ $art->tipologia->nome }}</span>@endif</td>
                            <td>{{ $s->data_scadenza->format('d/m/Y') }}</td>
                            <td><span class="badge bg-{{ $badge == 'orange' ? 'warning' : $badge }} {{ $badge == 'warning' ? 'text-dark' : '' }}">{{ $label }}</span></td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('scadenze.rinnova', $s) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-xs btn-outline-success" title="Rinnova"><i class="bi bi-arrow-clockwise"></i></button>
                                </form>
                                <a href="{{ route('scadenze.edit', $s) }}" class="btn btn-xs btn-outline-secondary ms-1"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    @empty
                        <tr><td colspan="5" class="text-muted text-center py-3">Nessun servizio registrato.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Domini --}}
            <div class="tab-pane fade" id="tab-domini">
                <div class="p-2 border-bottom d-flex justify-content-end">
                    <a href="{{ route('domini.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-xs btn-outline-primary">
                        <i class="bi bi-plus"></i> Aggiungi dominio
                    </a>
                </div>
                <table class="table table-hover mb-0 small align-middle">
                    <thead class="table-light"><tr><th>Dominio</th><th>Solo DNS</th><th>Registrazione</th><th>Mantenimento</th><th>Registrar</th><th></th></tr></thead>
                    <tbody>
                    @forelse($cliente->domini as $d)
                        <tr>
                            <td><a href="https://{{ $d->dominio }}" target="_blank" class="text-decoration-none">{{ $d->dominio }}</a></td>
                            <td>{{ $d->solo_dns ? 'Sì' : 'No' }}</td>
                            <td>{{ $d->data_registrazione?->format('d/m/Y') ?? '—' }}</td>
                            <td>{{ $d->data_inizio_mantenimento?->format('d/m/Y') ?? '—' }}</td>
                            <td>{{ $d->registrar ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('domini.edit', $d) }}" class="btn btn-xs btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted text-center py-3">Nessun dominio.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Credenziali --}}
            <div class="tab-pane fade" id="tab-credenziali" x-data="{}">
                <div class="p-2 border-bottom d-flex justify-content-end">
                    <a href="{{ route('credenziali.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-xs btn-outline-primary">
                        <i class="bi bi-plus"></i> Aggiungi credenziale
                    </a>
                </div>
                <table class="table table-hover mb-0 small align-middle">
                    <thead class="table-light"><tr><th>Tipo</th><th>URL</th><th>Username</th><th>Password</th><th>Note</th><th></th></tr></thead>
                    <tbody>
                    @forelse($cliente->credenziali as $cr)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $cr->tipo }}</span></td>
                            <td>@if($cr->url)<a href="{{ $cr->url }}" target="_blank" class="text-muted small">{{ Str::limit($cr->url, 40) }}</a>@else—@endif</td>
                            <td><code>{{ $cr->username }}</code></td>
                            <td>
                                <span x-data="{ pwd: '••••••••', shown: false }">
                                    <code x-text="pwd"></code>
                                    <button class="btn btn-xs btn-outline-secondary ms-1" @click="
                                        if (!shown) {
                                            fetch('{{ route('credenziali.password', $cr) }}', {headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}})
                                                .then(r=>r.json()).then(d=>{ pwd=d.password; shown=true; });
                                        } else { pwd='••••••••'; shown=false; }
                                    ">
                                        <i class="bi" :class="shown ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                </span>
                            </td>
                            <td class="text-muted">{{ $cr->note ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('credenziali.edit', $cr) }}" class="btn btn-xs btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted text-center py-3">Nessuna credenziale.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Progetti --}}
            <div class="tab-pane fade" id="tab-progetti">
                <div class="p-2 border-bottom d-flex justify-content-end">
                    <a href="{{ route('progetti.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-xs btn-outline-primary">
                        <i class="bi bi-plus"></i> Nuovo progetto
                    </a>
                </div>
                <table class="table table-hover mb-0 small align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Titolo</th>
                            <th>Stato</th>
                            <th class="text-end">Valore</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Step</th>
                            <th>Data offerta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($cliente->progetti as $p)
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
                        <tr>
                            <td>
                                <a href="{{ route('progetti.show', $p) }}" class="fw-semibold text-decoration-none text-dark">
                                    {{ $p->titolo }}
                                </a>
                            </td>
                            <td><span class="badge {{ $badge }}">{{ $label }}</span></td>
                            <td class="text-end fw-semibold">
                                {{ $p->valore_totale ? '€ '.number_format($p->valore_totale, 2, ',', '.') : '—' }}
                            </td>
                            <td class="text-center"><span class="badge bg-light text-dark">{{ $p->rate->count() }}</span></td>
                            <td class="text-center"><span class="badge bg-light text-dark">{{ $p->step->count() }}</span></td>
                            <td class="text-muted">{{ $p->data_offerta ? $p->data_offerta->format('d/m/Y') : '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('progetti.show', $p) }}" class="btn btn-xs btn-outline-primary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('progetti.edit', $p) }}" class="btn btn-xs btn-outline-secondary ms-1"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted text-center py-3">Nessun progetto registrato.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
