@extends('layout.main')

@section('topbar')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
@endsection

@section('content')
    
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                </div>
                <div class="card-body">

                    @if(Session::has('ok'))
                        <div class="alert {{ Session::get('ok') ? 'alert-success' : 'alert-danger' }}">{{ Session::get('ok') ? 'Operacja powiodła się' : 'Dupa blada' }}</div>
                    @else
                        <div class="alert alert-info">Brak operacji</div>
                    @endif

                    @if(Session::exists('ok'))
                        @if(Session::get('ok'))
                            <div class="alert alert-success">Exists - Operacja powiodła się</div>
                        @else
                            <div class="alert alert-danger">Exists - Operacja nie powiodła się</div>
                        @endif
                    @endif

                    <h2 class="mt-4">Panel admina</h2>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid aut molestias deserunt quasi esse, voluptates illo possimus, tempore perspiciatis cumque error obcaecati magni mollitia quod quos sapiente quas optio beatae?</p>
                </div>
            </div>

@endsection