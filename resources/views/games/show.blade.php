@extends('layout.main')

@section('content')


<div class="card shadow mb-4">
    @if(!empty($game))
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> {{ $game->title }}</h6>
        </div>
        <div class="card-body">
            <ul>
                <li>Id: {{ $game->id }}</li>
                <li>Nazwa: {{ $game->title }}</li>
                <li>Wydawca: {{ $game->publisher_id }}</li>
                <li>Kategoria: {{ $game->genre_id }}</li>
                <li>
                    Opis:
                    <div>{{ $game->description }}</div>
                </li>
            </ul>

            <a href="{{ route('get.games') }}" class="btn btn-light">Lista gier</a>
        </div>
    @else
    <h5 class="card-header">Brak danych do wyświetlenia</h5>
    @endif
</div>

@endsection