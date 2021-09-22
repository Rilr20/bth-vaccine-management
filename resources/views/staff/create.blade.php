@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
@php
    $error = $error ?? null;    
@endphp
<div class="staff-content">
    <h1>Create Staff</h1>
        <div class="Staff login-form-div">
            <form class="login-form" action="{{url("/staff")}}" method="POST">
                @csrf
                {{$error}}
                <div class="input-div">
                    <input class="input" type="text" name="fullname" placeholder="Full Name" required>
                </div>
                <div class="input-div">
                    <input class="input" type="email" name="email" placeholder="email@email.com" required>
                </div>
                <div class="input-div">
                    <input class="input" type="password" name="password" placeholder="password" required>
                </div>
                <div class="input-div-flex">
                    <input class="checkbox input" type="checkbox" name="is_admin" id="is_admin">
                    <label class="checkbox-label" value="1" for="is_admin">Admin</label>
                </div>
                <div class="input-div">
                    <input class="form-button login-button" type="submit" value="Create Staff">
                </div>
            </form>
        </div>
    </div>
@stop