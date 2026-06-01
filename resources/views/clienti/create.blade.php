@extends('layouts.app')
@section('title', 'Nuovo Cliente')
@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('clienti.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0">Nuovo Cliente</h5>
</div>
<div class="card" style="max-width:700px">
    <div class="card-body">
        <form method="POST" action="{{ route('clienti.store') }}">
            @csrf
            @include('clienti._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Salva</button>
                <a href="{{ route('clienti.index') }}" class="btn btn-outline-secondary">Annulla</a>
            </div>
        </form>
    </div>
</div>
@endsection
