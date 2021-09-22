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
                <p>
                    Name: {{$staff->fullname}} 
                    @if ($staff->is_admin == 1)
                        <img class="admin" src="{{asset('/img/wrench.png')}}" alt="admin icon">
                    @endif
                </p>
                <p>Email: {{$staff->email}}</p>
                @if ($staff->deleted_at != null)
                    <p>Deleted: {{$staff->deleted_at}}</p>
                @endif
            </div>
            <div>
                
                @if (Auth::user()->is_admin && $staff->deleted_at == null)
                    <a class="staff-link" href="{{url("staff/" . $staff->id)}}">Edit</a>
                @elseif(Auth::user()->is_admin && $staff->deleted_at != null)
                    <form action="{{url("/staff/$staff->id")}}" method="post">
                        @csrf
                        @method('delete')
                        <input class="delete button-link" type="submit" value="Reinstate">
                    </form>
                @endif
                
            </div>
        </div>
    @endforeach
</div>
@stop