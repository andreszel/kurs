@extends('layout.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Statystyki gier</h6>
    </div>
    <div class="card-body">
        <ul>
            <li>Liczba gier: {{ $stats['count'] }}</li>
            <li>Liczba gier 7+: {{ $stats['countScoreGtFive'] }}</li>
            <li>Min ocena: {{ $stats['min'] }}</li>
            <li>Max ocena: {{ $stats['max'] }}</li>
            <li>Średnia ocena: {{ $stats['avg'] }}</li>
        </ul>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Stats rates</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Ocena</th>
                        <th>Ilość gier</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Ocena</th>
                        <th>Ilość gier</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($scoreStats ?? [] as $stat)
                    <tr>
                        <td>{{ $stat->score }}</td>
                        <td>{{ $stat->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Najlepsze gry 9+</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Ocena</th>
                        <th>Kategoria</th>
                        <th>Wydawca</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Ocena</th>
                        <th>Kategoria</th>
                        <th>Wydawca</th>
                        <th>Opcje</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($bestGames ?? [] as $game)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $game->title }}</td>
                        <td>{{ $game->score }}</td>
                        <td>{{ $game->genre_name }}</td>
                        <td>{{ $game->publisher_name }}</td>
                        <td>
                            <a href="{{ route('games.qb.show', ['gameId' => $game->id]) }}">Szczegóły</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection