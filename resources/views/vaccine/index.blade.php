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
    @if (Auth::User()->is_admin == 1)
        <div class="login-form-div">
            <form class="login-form" action="{{url("/vaccine")}}" method="POST">
                @csrf
                <h3>Add New Vaccine</h3>
                <div class="input-div">
                    <label for="vaccine_type">Disease</label>
                    <input class="input" name="vaccine_type"type="text">
                </div>
                <div class="input-div">
                    <label for="vaccine_name">Vaccine name</label>
                    <input class="input" name="vaccine_name"type="text">
                </div>
                <input type="hidden" name="create_vaccine" value="true">
                <button type="submit" class="login-button">Create</button>

            </form>
        </div>
    @endif
   

    <div class="vaccine-div">
        <p>Disease</p>
        <p>Vaccine name</p>
        @foreach ($vaccines as $vaccine)
            <p>{{$vaccine->vaccine_type}}</p><p>{{$vaccine->vaccine_name}}</p>
        @endforeach
    </div>
</div>
@endsection