@extends('layouts.app')
@section('title', 'Nuova Scadenza')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('scadenze.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0">Nuova Scadenza</h5>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('scadenze.store') }}">
            @csrf
            @include('scadenze._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Salva</button>
                <a href="{{ route('scadenze.index') }}" class="btn btn-outline-secondary">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection
