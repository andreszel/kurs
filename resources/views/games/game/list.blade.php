@extends('layout.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Lista gier</h6>
    </div>
    <div class="card-body">

        <form class="form-inline" action="{{ route('games.list') }}">
            <div class="form-row">
                <label for="phrase" class="my-1 mr-2">Szukana fraza:</label>
                <div class="col">
                    <input type="text" class="form-control" name="phrase" placeholder="" value="{{ $phrase ?? ''}}">
                </div>
                @php $type = $type ?? ''; @endphp
                <div class="col-auto">
                    <select name="type" class="custom-select mr-sm-2">
                        <option @if ($type == 'all') selected @endif value="all">Wszystkie rodzaje</option>
                        <option @if ($type == 'game') selected @endif value="game">Gry</option>
                        <option @if ($type == 'dlc') selected @endif value="dlc">Dlc</option>
                        <option @if ($type == 'demo') selected @endif value="demo">Demo</option>
                        <option @if ($type == 'episode') selected @endif value="episode">Epizody</option>
                        <option @if ($type == 'mod') selected @endif value="mod">Mody</option>
                        <option @if ($type == 'movie') selected @endif value="movie">Filmy</option>
                        <option @if ($type == 'music') selected @endif value="music">Muzyka</option>
                        <option @if ($type == 'series') selected @endif value="series">Serie</option>
                        <option @if ($type == 'video') selected @endif value="video">Video</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-primary mb-1">Wyszukaj</button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Ocena</th>
                        <th>Typ</th>
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
                        <th>Typ</th>
                        <th>Kategoria</th>
                        <th>Wydawca</th>
                        <th>Opcje</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($games ?? [] as $game)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $game->name }}</td>
                        <td>{{ $game->metacritic_score }}</td>
                        <td>{{ $game->type }}</td>
                        <td>{{ $game->genres->implode('name', ',') }}</td>
                        <td>{{ $game->publishers->implode('name', ',') }}</td>
                        <td>
                            <a href="{{ route('games.show', ['gameId' => $game->id]) }}">Szczegóły</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-12">
                    {{ $games->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection