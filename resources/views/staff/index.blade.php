@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h1>{{Auth::user()->fullname}}</h1>

    <p>Created at: {{Auth::user()->created_at}}</p>
</div>
@stop