<!DOCTYPE html>
<html lang="en">
<!-- kalla inte på denna i web.php -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-small.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Vaccine Management - @yield('title')</title>

</head>

<body>
    <nav class="nav">
        <ul>
            <li><p>Vaccination Management</p></li>
            <li><a class="{{Request::path() == "/" ? 'active' : 'inactive'}}" href="{{url('/')}}">Main Page</a></li>
        </ul>
        <ul>
            <li><p></p></li>
            <li><a class="{{Request::path() == "login" ? 'active' : 'inactive'}}" href="{{url("/login")}}">Login</a></li>
        </ul>
    </nav>
    <main class="main">
        @yield('content')
    </main>
    <footer class="footer">
        <p class="center">Vaccination Management &copy; {{ date('Y')}}</p>
    </footer>
</body>

</html>