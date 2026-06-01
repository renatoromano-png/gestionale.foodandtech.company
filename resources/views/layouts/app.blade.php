<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestionale') — Food &amp; Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-w: 230px; }
        body { background: #f4f6f9; }
        #sidebar {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-w); background: #1a1f2e;
            display: flex; flex-direction: column; z-index: 1040;
            overflow-y: auto;
            transition: transform .25s ease;
        }
        #sidebar .brand { padding: 1.25rem 1rem 0.5rem; border-bottom: 1px solid #2d3450; }
        #sidebar .brand h6 { color: #7c8db5; font-size: .7rem; text-transform: uppercase; letter-spacing: .08em; margin: 0; }
        #sidebar .brand h5 { color: #fff; font-size: 1rem; margin: 0; }
        #sidebar .nav-link {
            color: #9aa5c4; padding: .45rem 1rem; border-radius: 6px;
            display: flex; align-items: center; gap: .5rem; font-size: .875rem;
            transition: background .15s, color .15s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background: #2d3450; color: #fff;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 1.25rem; text-align: center; }
        #sidebar .sidebar-section { font-size: .65rem; color: #4a5375; text-transform: uppercase;
            letter-spacing: .1em; padding: .75rem 1rem .25rem; }
        #sidebar .user-area { margin-top: auto; padding: .75rem 1rem; border-top: 1px solid #2d3450; }
        #sidebar .user-area small { color: #9aa5c4; }
        #main { margin-left: var(--sidebar-w); min-height: 100vh; }
        #topbar { background: #fff; border-bottom: 1px solid #e5e9f0;
            padding: .6rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        #sidebarToggle { display: none; background: none; border: none; color: #1a1f2e; font-size: 1.35rem; padding: 0 .5rem 0 0; cursor: pointer; line-height: 1; }
        #sidebarOverlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 1039; }
        .page-content { padding: 1.5rem; }
        .badge-scaduta   { background: #dc3545; }
        .badge-urgente   { background: #fd7e14; }
        .badge-attenzione{ background: #ffc107; color: #000; }
        .badge-ok        { background: #198754; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
        .table th { font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #6c757d; }
        .btn-xs { padding: .15rem .4rem; font-size: .75rem; }

        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            #sidebar { width: 230px; transform: translateX(-230px); }
            #sidebar.sidebar-open { transform: translateX(0); }
            #sidebarOverlay.show { display: block; }
            #sidebarToggle { display: inline-block; }
            #main { margin-left: 0; }
            #topbar { padding: .5rem 1rem; }
            .topbar-date { display: none; }
            .page-content { padding: .75rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav id="sidebar">
    <div class="brand">
        <h6>Food &amp; Tech</h6>
        <h5>Gestionale</h5>
    </div>
    <div class="px-2 py-3 flex-grow-1">
        <div class="sidebar-section">Principale</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('clienti.index') }}" class="nav-link {{ request()->routeIs('clienti.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Clienti
        </a>

        <div class="sidebar-section mt-2">Servizi</div>
        <a href="{{ route('scadenze.index') }}" class="nav-link {{ request()->routeIs('scadenze.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Scadenze
        </a>
        <a href="{{ route('domini.index') }}" class="nav-link {{ request()->routeIs('domini.*') ? 'active' : '' }}">
            <i class="bi bi-globe"></i> Domini
        </a>
        <a href="{{ route('credenziali.index') }}" class="nav-link {{ request()->routeIs('credenziali.*') ? 'active' : '' }}">
            <i class="bi bi-key"></i> Account / Credenziali
        </a>

        <div class="sidebar-section mt-2">Commerciale</div>
        <a href="{{ route('fatturazione.index') }}" class="nav-link {{ request()->routeIs('fatturazione.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Fatturazione
        </a>
        <a href="{{ route('progetti.index') }}" class="nav-link {{ request()->routeIs('progetti.*') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i> Progetti
        </a>
        <a href="#" class="nav-link text-muted" title="In sviluppo">
            <i class="bi bi-graph-up-arrow"></i> Forecast <span class="badge bg-secondary ms-auto" style="font-size:.6rem">presto</span>
        </a>

        <div class="sidebar-section mt-2">Impostazioni</div>
        <a href="{{ route('tipologie.index') }}" class="nav-link {{ request()->routeIs('tipologie.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Tipologie Servizio
        </a>
    </div>
    <div class="user-area">
        <small class="d-block mb-1"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->nome }}</small>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary w-100" style="font-size:.75rem">
                <i class="bi bi-box-arrow-right"></i> Esci
            </button>
        </form>
    </div>
</nav>

<div id="sidebarOverlay"></div>

<div id="main">
    <div id="topbar">
        <div class="d-flex align-items-center gap-2">
            <button id="sidebarToggle" aria-label="Menu"><i class="bi bi-list"></i></button>
            <span class="fw-semibold text-dark">@yield('title', 'Dashboard')</span>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="text-muted small topbar-date">{{ now()->locale('it')->isoFormat('dddd D MMMM YYYY') }}</span>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>
<script>
(function() {
    var sidebar  = document.getElementById('sidebar');
    var overlay  = document.getElementById('sidebarOverlay');
    var toggle   = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('sidebar-open');
        overlay.classList.add('show');
    }
    function closeSidebar() {
        sidebar.classList.remove('sidebar-open');
        overlay.classList.remove('show');
    }

    toggle.addEventListener('click', function() {
        sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar();
    });
    overlay.addEventListener('click', closeSidebar);

    // Chiudi la sidebar quando si clicca un link (utile su mobile)
    sidebar.querySelectorAll('.nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });
})();
</script>
@stack('scripts')
</body>
</html>
