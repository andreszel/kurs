@extends('layout.main')

@section('title', 'Profil użytkownika')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">{{ $user->name }}</h5>
    </div>
    <div class="card-body">
        <ul>
            <li>Id: {{ $user->id }}</li>
            <li>Imię: {{ $user->name }}</li>
            <li>Email: {{ $user->email }}</li>
            <li>Telefon:
                @if ($user->phone)
                <span>OK</span>
                @else
                <span>EMPTY</span>
                @endif
            </li>
        </ul>

        <a href="{{ route('get.users') }}" class="btn btn-sm btn-light">Lista użytkowników</a>
    </div>
</div>
@endsection