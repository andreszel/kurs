@extends('layout.main')

@section('title', 'Profil użytkownika')

@section('sidebar')
    @parent
    DZIECKO
    Sidebar z dziecka
@endsection

@section('content')
<h1>{{$titleName}}</h1>
<div>
    <p>ID: {{$user['id']}}</p>
    <p>App Name: {{$appName}}</p>
</div>
<hr>
    @auth
        Informuje czy użytkownik est zalogowany
    @endauth

    @guest
        Użytkownik nie jest zalogowany
    @endguest
<hr>
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

    @isset($nick)
        Nick: true
    @else
        Nick: false
    @endisset

    @empty($nick)
        EMPTY: true
    @else
        EMPTY: false
    @endempty
</ul>

<div>
    {{ $user['html'] }}
    <br>
    {!! $user['html'] !!}
</div>
@endsection