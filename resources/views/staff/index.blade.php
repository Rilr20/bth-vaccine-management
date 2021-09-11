@extends('layout/main')
@section('title', $title ?? "no title")
@section('content')
<div class="content">
    <h1>Staff Page</h1>

    <h1>Vaccine info</h1>


    <h1>Admin Stuff hidden if not admin</h1>
    <h2>Create Staff</h2>
    <h2>Manage Staff</h2>
</div>
@stop