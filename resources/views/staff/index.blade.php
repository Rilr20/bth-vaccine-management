@extends('layout/main')
@section('title', $title ?? "no title")
@section('content')
<div class="content">
    <h1>Staff Page</h1>

    <h2>Vaccine info</h2>
    <h2>New Vaccination</h2>

    {{-- {{Auth::user()->is_admin}} --}}
    @if(Auth::user()->is_admin == 1)
        {{-- <h1>Admin Stuff hidden if not admin</h1> --}}
        <h2>Create Staff</h2>
            <a href="">create new staff</a>
        <h2>Manage Staff</h2>
            <a href="">Staff list</a>
    @endif
</div>
@stop