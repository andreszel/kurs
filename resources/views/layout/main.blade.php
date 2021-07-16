<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $titleName)</title>
    <style>
        td {
            padding-right: 15px;
        }
    </style>
</head>
<body>
    <h1>{{$appName}}</h1>

    <div class="sidebar">
        RODZIC
        @section('sidebar')
            <ul>
                <li><a href="#">Link 1</a></li>
                <li><a href="#">Link 2</a></li>
                <li><a href="#">Link 3</a></li>
            </ul>
        @show
    </div>

    <hr />

    <div class="container">
        @yield('content')
    </div>
</body>
</html>