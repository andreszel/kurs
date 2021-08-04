@extends('layout.main')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Lista gier</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
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
                    @foreach($games ?? [] as $game)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $game->title }}</td>
                            <td>{{ $game->score }}</td>
                            <td>{{ $game->genre_name }}</td>
                            <td>{{ $game->publisher_name }}</td>
                            <td>
                                <a href="{{ route('show.game', ['gameId' => $game->id]) }}">Szczegóły</a>
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