@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
@php
    $error = $error ?? null;
@endphp
<div class="staff-content">
    <h1>{{$staff->fullname}}'s Page</h1>

    <h2>Edit Information</h2>
    @php
        // dd($staffs);
        // echo $staff->id;
    @endphp
    
    {{-- @foreach ($staffs as $staff) --}}
        <div class="Staff login-form-div">
            {{$error}}
            <form class="login-form" action="{{url("/staff/$staff->id")}}" method="POST">
            {{-- <form action="/staff/{{$staff->id}}" method="POST"> --}}
                @csrf
                @method('PUT')
                <div class="input-div">
                    <input class="input" type="text" name="fullname" value="{{$staff->fullname}}" placeholder="Full Name">
                </div>
                <div class="input-div">
                    <input class="input" type="password" name="password" placeholder="password" required>
                </div>

                @if (Auth::user()->is_admin == 1)
                    <div class="input-div">
                    <input class="input" type="email" name="email" value="{{$staff->email}}" placeholder="email@email.com">
                    </div>
                    <div class="input-div-flex">
                        <input class="checkbox input" type="checkbox" name="is_admin" id="is_admin">
                        <label class="checkbox-label" value="1" for="is_admin">Admin</label>
                    </div>
                @else 
                    <input type="hidden" name="email" value="{{$staff->email}}">
                    {{-- <input type="hidden" name="is_admin" value="{{$staff->is_admin}}"> --}}
                @endif

                <div class="input-div">
                    <input class="form-button login-button" type="submit" value="Send">
                </div>
            </form>
        </div>
    {{-- @endforeach --}}
</div>
@stop