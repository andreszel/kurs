@extends('layout.main')

@section('content')
    <div class="card mt-3">
        <h5 class="card-header">{{ $user->name }}</h5>
        <div class="card-body">

        <!-- Grupowe wyświetlanie błędów -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form action="{{ route('me.update') }}" method="post" enctype="multipart/form-data" class="test">
                @csrf
                <!-- X-XSRF-TOKEN -->
                @if ($user->avatar)
                    <div class="col-md-2">
                        <img src="{{ Storage::url($user->avatar) }}" alt="User avatar default" class="rounded mx-auto d-block mb-5">
                    </div>
                @else
                    <div class="col-md-2">
                        <img src="/admin/img/undraw_profile.svg" alt="User avatar default" class="rounded mx-auto d-block mb-5">
                    </div>
                @endif

                <div class="form-group">
                    <label for="avatar">Wybierz avatar ...</label>
                    <input type="file" class="form-control-file" id="avatar" name="avatar">
                    @error('avatar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nazwa</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Adres email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">
                    Zapisz
                </button>
            </form>

        </div>
    </div>
@endsection