@extends('layout.main')

@section('title', 'Profil użytkownika')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">{{ $user['firstName'] }} {{ $user['lastName'] }}</h5>
        </div>
        <div class="card-body">
            <ul>
                <li>Id: {{ $user['id'] }}</li>
                <li>Imię: {{ $user['firstName'] }}</li>
                <li>Nazwisko: {{ $user['lastName'] }}</li>
                <li>Miejscowość: {{ $user['city'] }}</li>
                <li>
                    Wiek: {{ $user['age'] }}
                    @if ($user['age'] >= 18)
                        <span>OSOBA DOROSŁA</span>
                    @elseif ($user['age'] >= 16)
                        <span>PRAWIE DOROSŁA</span>
                    @else
                        <span>NASTOLATEK</span>
                    @endif
                </li>
            </ul>

            <a href="{{ route('get.users') }}" class="btn btn-sm btn-light">Lista użytkowników</a>
        </div>
    </div>            
@endsection