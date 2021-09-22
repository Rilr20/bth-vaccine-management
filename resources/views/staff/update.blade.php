@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h1>{{$staff->fullname}}'s Page</h1>
    <h2>User Information</h2>
    <div class="user-div">
    <div class="user-form">
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
        </div>
        {{-- <a class="h2-link delete" href="{{url("/staff/" . $staff->id . "/edit")}}">DELETE</a> --}}
    </h2>
    @php
// dd($staffs);
        // echo $staff->id;
    @endphp
    <!--Personal page-->
    {{-- @foreach ($staffs as $staff) --}}
        <div class="Staff">
            
            <h3>Name: {{$staff->fullname}}</h3>
            <h3>Email: {{$staff->email}}</h3>
            @if ($staff->is_admin == 1)
                <h3>Admin: Yes</h3>
            @else
                <h3>Admin: No</h3>
            @endif
            @if ($staff->deleted_at != null)
                <h3>Deleted: {{$staff->deleted_at}}</h3>
            @endif
        </div>
    </div>
    {{-- @endforeach --}}
</div>
@stop