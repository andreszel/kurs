@extends('layout.main')

@section('content')

<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Moje gry</h6>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Kategoria</th>
                        <th>Ocena</th>
                        <th>Twoja ocena</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Kategoria</th>
                        <th>Ocena</th>
                        <th>Twoja ocena</th>
                        <th>Opcje</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($games ?? [] as $game)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $game->name }}</td>
                        <td>{{ $game->genres->implode('name', ',') }}</td>
                        <td>{{ $game->metacritic_score ?? 'brak' }}</td>
                        <td>
                            <form action="{{ route('me.games.rate') }}" method="post" class="m-0">
                                @csrf
                                <div class="form-row">
                                    <input type="hidden" name="gameId" value="{{ $game->id }}">
                                    <div class="col-auto">
                                        <input
                                            class="form-control mb-2"
                                            placeholder="ocena"
                                            type="number"
                                            max="100"
                                            min="1"
                                            name="rate"
                                            value="{{ $game->pivot->rate }}"
                                        />
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary mb-2">Oceń</button>
                                    </div>
                                </div>
                            </form>
                        </td>
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