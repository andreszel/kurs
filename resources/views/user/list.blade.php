@extends('layout.main')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Lista użytkowników</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>Lp</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Opcje</th>
                </thead>
                <tbody>
                    @each('user.listRow', $users, 'userData', 'user.emptyRow')
                </tbody>
            </table>
        </div>
    </div>
@endsection