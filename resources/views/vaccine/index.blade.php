@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h2 class="center">All Vaccine</h2>
    {{-- <h2>Search</h2> --}}
    {{-- @php
        // dd($vaccine);
        foreach ($vaccines as $vaccine) {
            echo $vaccine->vaccine_type;
            echo $vaccine->vaccine_name;
        }
    @endphp --}}
    {{-- <h2>All Vaccine</h2> --}}
    <div class="vaccine-div">
        <p>Disease</p>
        <p>Vaccine name</p>
        @foreach ($vaccines as $vaccine)
            <p>{{$vaccine->vaccine_type}}</p><p>{{$vaccine->vaccine_name}}</p>
        @endforeach
    </div>
</div>
@endsection