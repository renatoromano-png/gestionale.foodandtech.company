@if ($paginator->hasPages())
<nav aria-label="Navigazione pagine">
    <ul class="pagination pagination-sm justify-content-start mb-0">
        {{-- Precedente --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">‹ Prec.</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Prec.</a></li>
        @endif

        {{-- Numeri pagina --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Successivo --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Succ. ›</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Succ. ›</span></li>
        @endif
    </ul>
    <small class="text-muted mt-1 d-block">
        {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} di {{ $paginator->total() }} risultati
    </small>
</nav>
@endif
