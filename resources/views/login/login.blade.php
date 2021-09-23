@extends('layout/main')
@section('title', $title ?? "no title")
@php
    $wrong = $wrong ?? null;
@endphp
@section('content')
<div class="login-form-div">
        <h1 class="center">Login</h1>
        <div class="error">
            <p class="text-error red-colour">{{$wrong}}</p>
        </div>
        <form class="login-form" action="{{url('/login/checklogin')}}" method="POST">
            @csrf
            <div class="input-div">
                <input class="input" type="text" name="email" placeholder="email@email.com" required>
            </div>
            <div class="input-div">
                <input class="input" type="password" name="password" placeholder="password" required>
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
@endsection