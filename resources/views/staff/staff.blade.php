@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h1>Staff List</h1>

    {{-- @php
        dd($staffs);
    @endphp --}}
    
    @foreach ($staffs as $staff)
        <div class="staff-list">
            <div class="left-box">
                <div class="second-box">
                    <p>{{$staff->id}}</p>
                </div>
            </div>
            <div class="right-box">
                 <p>Name: {{$staff->fullname}}</p>
            <p>Email: {{$staff->email}}</p>
            </div>
            <div>
                @if ($staff->is_admin == 1)
                    <img class="admin" src="{{asset('/img/wrench.png')}}" alt="admin icon">
                @endif
                @if (Auth::user()->is_admin)
                    <a class="staff-link" href="{{url("staff/" . $staff->id)}}">Edit</a>
                @endif
                @if ($staff->deleted_at != null)
                    <p>Deleted: {{$staff->deleted_at}}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
@stop