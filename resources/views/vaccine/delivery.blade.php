@extends('layout/staff')
@section('title', $title ?? "no title")
@section('content')
<div class="staff-content">
    <h2 class="center">Vaccine Delivery</h2>
    {{-- <h2>Search</h2> --}}
    {{-- @php
        // dd($vaccine);
        foreach ($vaccines as $vaccine) {
            echo $vaccine->vaccine_type;
            echo $vaccine->vaccine_name;
        }
    @endphp --}}
    {{-- <h2>All Vaccine</h2> --}}
    {{-- <div class="vaccine-div"> --}}
        <form action="{{url("/vaccine")}}" method="POST">
            @csrf
            <div class="delivery-button-div">
                <input class="button delivery-button" type="submit" value="Confirm">
            </div>
            <table>
                <thead>
                    <th>Disease</th>
                    <th>Vaccine Name</th>
                    <th>Vaccines left</th>
                    <th>Delivery</th>
                </thead>
                    @foreach ($vaccines as $vaccine)
                    <tr>
                        <td>{{$vaccine->vaccine_type}}</td>
                        <td>{{$vaccine->vaccine_name}}</td>
                        <td>{{$vaccine->count}}</td>
                        <td><input type="number" name="{{$vaccine->id}}"></td>
                    </tr>
                    @endforeach
                </table>
                <input type="hidden" name="vaccine_delivery" value="true">
                
        </form>
</div>


    {{-- <p>Disease</p> --}}
    {{-- <p>Vaccine name</p> --}}

@endsection