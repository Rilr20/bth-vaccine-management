@extends('layout/staff')
@section('title', $title ?? "no title")
@php
    $error = $error ?? null;
@endphp
@section('content')
<div class="staff-content">
    <h2 class="center">New Vaccination</h2>
    <div class="vaccine login-form-div">
        <h2>Vaccine</h2>
        <p>{{$error}}</p>
        <form action="{{url("/vaccine")}}" method="POST">
            @csrf
                <h2>Create Patient</h2>
            {{-- <div class="input-div">
                <label for="personnumber">Person number</label>
                <input class="input" type="text" name="personnumber" placeholder="XXXXXX1234" required>
            </div> --}}
            <div class="input-div">
                <label for="name">Full name</label>
                <input class="input" type="text" name="name" placeholder="Full name" >
            </div>
            <div class="input-div">
                <label for="phonenumber"  >Phonenumber</label>

                <input class="input" type="text" name="phonenumber" maxlength="15" placeholder="phonenumber" >
            </div>
            <div class="input-div">
                <label for="birthdate">Birthdate</label>
                <input class="input" type="date" name="birthdate">
            </div>
            <div class="input-div">
                <label for="gender">Gender</label>
                <select class="input select" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="input-div">
                <label for="journal">Journal</label>
                <textarea class="input textarea" name="journal"cols="30" rows="10" name="journal"></textarea>
            </div>
            <div class="input-div">
                <label for="personnumber">Person number</label>
                <input class="input" type="text" name="personnumber" placeholder="XXXXXX1234" maxlength="10" required>
            </div>
            <div class="input-div">
                <label for="vaccine_id">Vaccine</label>
                <select class="input select" name="vaccine_id">
                    <option selected="true" disabled="disabled">Select Vaccine</option>
                    {{-- <option>Select Vgsdaccine</option>
                    <option >Selasgdect Vaccine</option>
                    <option>Select Vasdgaccine</option> --}}
                    @foreach ($vaccines as $vaccine)
                        <option value="{{$vaccine->id}}">{{$vaccine->vaccine_name }} | {{ $vaccine->vaccine_type}}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="staff" value="{{Auth::user()->id}}">
            <div class="input-div">
                <input class="form-button login-button" type="submit" value="Done">
            </div>
        </form>
    </div>
    {{-- <div class="patient login-form-div">

        <div class="input-div">
            <input class="form-button login-button" type="submit" value="Done">
        </div>
    </div> --}}
</div>
@endsection