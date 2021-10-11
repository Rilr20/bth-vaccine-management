@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h1>{{Auth::user()->fullname}}</h1>

    <p>Created at: {{Auth::user()->created_at}}</p>
    <div class="staff-history">
        <h3>History</h3>
        @foreach ($history as $row)
            <p class="history">patient {{$row->patient_id}}, vaccine {{$row->vaccine_id}}, {{$row->created_at}}</p>
        @endforeach
    </div>
    <h2>Upcoming</h2>
    <div class="staff-history">
    @foreach ($schedule as $row)
        <p class="history">patient {{$row->patient}} {{$row->disease}} {{$row->booked}}</p>
    @endforeach
    </div>
</div>
@stop