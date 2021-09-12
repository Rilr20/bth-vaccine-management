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
            @if (Auth::user())
                <li><a class="{{Request::path() == "/staff" ? 'active' : 'inactive'}}" href="{{url('/staff')}}">Staff</a></li>
            @endif
        </ul>
        <ul>
            <li><p></p></li>
            @if (Auth::user())
                    <li class="no-link">User: {{Auth::user()->fullname}}</li>
                    <li><a href="{{url('/login/logout')}}">Logout</a></li>    
            @else
                <li  class="{{Request::path() == "login" ? 'active' : ''}}"><a href="{{url('/login')}}">Login</a></li>
            @endif
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