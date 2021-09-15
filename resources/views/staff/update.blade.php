@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h1>{{$staff->fullname}}'s Page</h1>
    <h2>User Information</h2>
        <form action="{{url("/staff/$staff->id")}}" method="POST">
            @csrf
            @method('delete')
    <h2><a class="h2-link" href="{{url("/staff/" . $staff->id . "/edit")}}">Edit</a>
            {{-- visa ej om du är admin och kontot är admin och visa ej om du inte är admin --}}
            {{-- !Auth::user->is_admin && $staff->is_admin || Auth::user->is:admin --}}
            @if (Auth::user()->is_admin == 1 && $staff->is_admin == 0 || Auth::user()->id == $staff->id && Auth::user()->is_admin)
                <input class="h2-link delete button-link" type="submit" value="DELETE">
            @endif
        </form>
        {{-- <a class="h2-link delete" href="{{url("/staff/" . $staff->id . "/edit")}}">DELETE</a> --}}
    </h2>
    
    @php

// dd($staffs);
        // echo $staff->id;
    @endphp
    <!--Personal page-->
    {{-- @foreach ($staffs as $staff) --}}
        <div class="Staff">
            
            <p>Name: {{$staff->fullname}}</p>
            <p>Email: {{$staff->email}}</p>
            @if ($staff->is_admin == 1)
                <p>Admin: Yes</p>
                
            @else
                <p>Admin: No</p>
            @endif
            @if ($staff->deleted_at != null)
                <p>Deleted: {{$staff->deleted_at}}</p>
            @endif
        </div>
    {{-- @endforeach --}}
</div>
@stop