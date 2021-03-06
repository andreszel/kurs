@extends('layout.main')

@section('content')
    <div class="card mt-3">
        <h5 class="card-header">{{ $user->name }}</h5>
        <div class="card-body">
            @if ($user->avatar)
                <div class="col-md-2">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="User avatar image" class="rounded mx-auto d-block mb-5">
                </div>
            @else
                <div class="col-md-2">
                    <img src="/admin/img/undraw_profile.svg" alt="User avatar default" class="rounded mx-auto d-block mb-5">
                </div>
            @endif
            
            <ul>
                <li>Nazwa: {{ $user->name }}</li>
                <li>Email: {{ $user->email }}</li>
                <li>Telefon: {{ $user->phone }}</li>
            </ul>

            <a href="{{ route('me.edit') }}" class="btn btn-light">Edytuj dane</a>
        </div>
    </div>
@endsection