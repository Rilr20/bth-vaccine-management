@php
    $staff = false;
    if(str_contains(Request::path(), "staff")){
        $staff = true;
    }
@endphp
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
                <li><a class="{{$staff ? 'active' : 'inactive'}}" href="{{url('/staff')}}">Staff</a></li>
                <li><a class="{{Request::path() == "vaccine" ? 'active' : 'inactive'}}" href="{{url('/vaccine')}}">Vaccine</a></li>
            @endif
            <li><a class="{{Request::path() == "patient" ? 'active' : 'inactive'}}" href="{{url('/patient')}}">Patient</a></li>
        </ul>
        <ul>
            <li><p></p></li>
            @if (Auth::user())
                    <li class="no-link">User: <a href="{{url("/staff/" . Auth::user()->id)}}">{{Auth::user()->fullname}}</a> </li>
                    <li><a href="{{url('/login/logout')}}">Logout</a></li>    
            @else
                <li  class="{{Request::path() == "login" ? 'active' : ''}}"><a href="{{url('/login')}}">Login</a></li>
            @endif
        </ul>
    </nav>
    <main class="main">
        <div class="content">

            <div class="staff">

                <div class="title">
                    {{-- <h1>Staff Page</h1> --}}
                </div>

                <div class="link-list">
                    <h2>Staff</h2>
                    <a href="{{url("/staff/list")}}">Staff List</a>
                    <h2>Vaccine info</h2>
                    <a href="{{url("/vaccine")}}">Vaccine Info</a>
                    {{-- <h2>New Vaccination</h2> --}}
                    <a href="{{url("/vaccine/create")}}">New Vaccination</a>
                    @if(Auth::user()->is_admin == 1)
                    {{-- <h1>Admin Stuff hidden if not admin</h1> --}}
                    <h2>Admin</h2>
                    <a href="{{url("/staff/create")}}">Create New Staff</a>
                    <a href="{{url("/staff/admin")}}">Staff List</a>
                @endif
                </div>

                @yield('content')

            </div>
        </div>
    </main>
    <footer class="footer">
        <p class="center">Vaccination Management &copy; {{ date('Y')}}</p>
    </footer>
</body>

</html>